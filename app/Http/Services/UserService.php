<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    /**
     * Retorna uma lista paginada de usuários.
     */
    public function getAllUsers($perPage = 10)
    {
        return User::select('id', 'name', 'email', 'created_at')->paginate($perPage);
    }

    /**
     * Retorna o usuário atualmente autenticado.
     */
    public function getAuthenticatedUser()
    {
        return auth()->user();
    }

    /**
     * Cria um novo usuário com os dados fornecidos.
     */
    public function createUser(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        
        return User::create($data);
    }

    /**
     * Retorna um usuário pelo ID.
     */
    public function getUserById($id)
    {
        return User::find($id);
    }

    /**
     * Atualiza os dados de um usuário existente.
     */
    public function updateUser($id, array $data)
    {
        $user = User::find($id);

        if (!$user) {
            return null;
        }

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);

        return $user;
    }

    /**
     * Exclui um usuário pelo ID.
     */
    public function deleteUser($id)
    {
        $user = User::find($id);

        if ($user) {
            $user->delete();
            return true;
        }

        return false;
    }
}