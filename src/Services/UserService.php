<?php

namespace Services;

use Models\User;
use Repositories\UserRepository;

class UserService
{

    private UserRepository $userRepository;


    public function __construct(){
        $this->userRepository = new UserRepository();

    }

    public function registerUser(User $user):void{
        $this->userRepository->registerUser($user);
    }

    public function getUserByEmail(string $email){
       return $this->userRepository->getUserByEmail($email);
    }

    public function getUserById(int $id){
        return $this->userRepository->getUserById($id);
    }

    public function actualizarRegistro(User $user):bool{
       return $this->userRepository->actualizarRegistro($user);
    }
}