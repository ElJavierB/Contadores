<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    
    /**
     * Display a listing of the users.
     */
    public function index()
    {
        $user = Auth::user();
        return view('users.users', compact('user'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'phone' => ['required', 'string', 'max:15'],
            'birth' => ['nullable', 'date'],
            'profile_photo' => ['nullable', 'image', 'max:2048'],
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        $profilePhotoPath = null;
        if ($request->hasFile('profile_photo')) {
            $profilePhotoPath = $request->file('profile_photo')->store('profile_photos', 'public');
        }
    
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'birth' => $request->birth,
            'profile_photo' => $profilePhotoPath,
        ]);
    
        return redirect()->route('users.list')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:15',
            'birth' => 'nullable|date',
            'password' => 'nullable|string|min:8|confirmed',
            'profile_photo' => 'nullable|image|max:2048',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        $data = $request->only(['name', 'email', 'phone', 'birth']);
    
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
    
        // Verificar si se subió una nueva foto
        if ($request->hasFile('profile_photo')) {
            // Eliminar la foto anterior si existe
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }
    
            // Guardar la nueva foto
            $profilePhotoPath = $request->file('profile_photo')->store('profile_photos', 'public');
            $data['profile_photo'] = $profilePhotoPath; // Guardar la nueva ruta en la base de datos
        }
    
        // Actualizar el usuario con los nuevos datos
        $user->update($data);
    
        return redirect()->route('users.index')->with('success', 'Perfil actualizado exitosamente.');
    }

    public function deletePhoto(User $user)
    {
        // Verificar si el usuario tiene una foto de perfil
        if ($user->profile_photo) {
            // Eliminar la foto de perfil del almacenamiento
            Storage::disk('public')->delete($user->profile_photo);

            // Eliminar la referencia de la foto de perfil en la base de datos
            $user->profile_photo = null;
            $user->save();
        }

        return redirect()->route('users.index')->with('success', 'Foto de perfil eliminada exitosamente.');
    }

    public function listClients(Request $request)
    {
        $query = User::query();

        // Filtrar por búsqueda
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%');
            });
        }
    
        // Ordenar por columna
        if ($request->has('sort_by')) {
            $sort_by = $request->get('sort_by');
            $order = $request->get('order', 'asc');
            $query->orderBy($sort_by, $order);
        }
    
        // Obtener el número de resultados por página
        $perPage = $request->get('per_page', 5); // Valor predeterminado de 5
    
        $clients = $query->paginate($perPage);
    
        return view('users.list', compact('clients'));
    }

    public function destroy(User $user)
    {
        $authUser = Auth::user();

        // Solo marcar como eliminado sin borrar la foto
        $user->delete();

        // Si el usuario elimina su propia cuenta, cerrar sesión
        if ($authUser->id === $user->id) {
            Auth::logout();
            return redirect('/')->with('success', 'Cuenta eliminada exitosamente.');
        }

        return redirect()->route('users.index')->with('success', 'Usuario eliminado exitosamente.');
    }

    /**
     * Restaurar un usuario eliminado
     */
    public function restore($id)
    {
        $user = User::withTrashed()->find($id);

        if (!$user) {
            return redirect()->route('users.index')->with('error', 'Usuario no encontrado.');
        }

        $user->restore();

        return redirect()->route('users.index')->with('success', 'Usuario restaurado exitosamente.');
    }

    /**
     * Mostrar usuarios eliminados
     */
    public function trashed()
    {
        $deletedUsers = User::onlyTrashed()->paginate(10);
        return view('users.trashed', compact('deletedUsers'));
    }

}