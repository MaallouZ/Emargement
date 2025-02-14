<?php

class User
{
    // Attributes
    private int $id;
    private string $lastName;
    private string $firstName;
    private string $email;
    private string $pwd;
    private ?string $perm;

    //Constructor
    public function __construct(int $id, string $lastName, string $firstName, string $email, string $pwd, ?string $perm = null){
        $this->id = $id;
        $this->lastName = $lastName;
        $this->firstName = $firstName;
        $this->email = $email;
        $this->pwd = $pwd;
        $this->perm = $perm;
    }

    // Getters
    public function getId():int{
        return $this->id;
    }
    public function getLastName(): string{
        return $this->lastName;
    }
    public function getFirstName(): string{
        return $this->firstName;
    }
    public function getEmail(): string{
        return $this->email;
    }
    public function getPWD(): string{
        return $this->pwd;
    }
    public function getPerm(): ?string{
        return $this->perm;
    }

    // setters
    public function setId(int $id){
        $this->id = $id;
    }
    public function setLastName(string $lastName){
        $this->lastName = $lastName;
    }
    public function setFirstName(string $firstName){
        $this->firstName = $firstName;
    }
    public function setEmail(string $email){
        $this->email = $email;
    }
    public function setPWD(string $pwd){
        $this->pwd = $pwd;
    }
    public function setPerm(?string $perm){
        $this->perm = $perm;
    }
}

class UserRepository extends Repository
{
    // Methods
    public function findUserByEmail(string $email): ?User{

        $stmt = $this -> conn -> prepare('SELECT * FROM user WHERE emailUser = :email');
        $stmt -> bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $user = new User(
                $result['idUser'],
                $result['nomUser'],
                $result['prenomUser'],
                $result['emailUser'],
                $result['mdpUser'],
                $result['perm']
            );

        return $user;
        } else {
            return null;
        }
    }

    public function setToken(int $id, string $token){

        $stmt = $this -> conn -> prepare('UPDATE user SET token = :token WHERE user.idUser = :idUser ;');
        $stmt -> bindParam('idUser', $id, PDO::PARAM_INT);
        $stmt -> bindParam('token', $token, PDO::PARAM_STR);

        try {
            $stmt ->execute();
            $result = $stmt -> fetch();
        } catch (PDOException $ex) {
            return $ex -> getMessage();
            exit();
        }

        if (isset($result)) {
            return true;
        }
        else {
            return false;
        }
    }
}