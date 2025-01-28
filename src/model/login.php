<?php

function authenticate(string $email, string $pwd, Database $db): ?array
{
    $userRepo = new UserRepository($db);
    $user = $userRepo->findUserByEmail($email);

    if ($user && password_verify($pwd, $user->getPWD())) {
        $token = bin2hex(random_bytes(32));
        $userRepo->setToken($user->getId(), $token);
        setcookie("token", $token, time() + 14400);

        return [
            'id' => $user->getId(),
            'lastName' => $user->getLastName(),
            'firstName' => $user->getFirstName(),
            'email' => $user->getEmail(),
        ];
    } else {
        return NULL;
    }
}
