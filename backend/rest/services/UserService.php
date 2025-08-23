<?php
require_once dirname(__FILE__) . '/BaseService.php';
require_once dirname(__FILE__) . '/../dao/UserDao.class.php';
require_once dirname(__FILE__) . '/../../data/Roles.php';

use Firebase\JWT\JWT;

class UserService extends BaseService
{

    public function __construct()
    {
        parent::__construct(new UserDao());
    }

    public function get_all_users($size, $page)
    {
        return $this->dao->get_all_users($size, $page);
    }

    public function get_user_by_id($id)
    {
        return $this->dao->get_user_by_id($id);
    }

    public function delete_user($id)
    {
        return $this->dao->delete_user($id);
    }

    public function add($entity)
    {
        return $this->dao->add_user($entity);
    }

    public function update($entity, $id)
    {
        return $this->dao->update_entity($entity, $id);
    }

    public function register($data)
    {
        $first_name = $data['first_name'] ?? '';
        $last_name = $data['last_name'] ?? '';
        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';

        if (empty($first_name)) {
            Flight::json(['message' => 'First name is required'], 400);
            return;
        }

        if (empty($last_name)) {
            Flight::json(['message' => 'Last name is required'], 400);
            return;
        }

        if (empty($password)) {
            Flight::json(['message' => 'Password is required'], 400);
            return;
        }

        if (strlen($password) < 8) {
            Flight::json(['message' => 'Password must be at least 8 characters long'], 400);
            return;
        }

        if (empty($email)) {
            Flight::json(['message' => 'Email is required'], 400);
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Flight::json(['message' => 'Email is not valid'], 400);
            return;
        }

        $users = $this->dao->find_user_by_email($email);

        if ($this->is_user_active($users)) {
            Flight::json(['message' => 'Email is already taken'], 400);
            return;
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);

        $this->dao->add([
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'password' => $hash,
            'role' => Roles::USER,
        ]);

        Flight::json(['message' => 'Registration successful'], 200);
    }


    public function login($data)
    {
        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';

        if (empty($email)) {
            Flight::json(['message' => 'Email is required'], 400);
            return;
        }

        if (empty($password)) {
            Flight::json(['message' => 'Password is required'], 400);
            return;
        }

        $users = $this->dao->find_user_by_email($email);

        $active_user = $this->get_active_user($users);

        if (!$active_user || !password_verify($password, $active_user['password'])) {
            Flight::json(['message' => 'Email or password is not correct'], 401);
            return;
        }

        $issuedAt = time();
        $expirationTime = $issuedAt + (7 * 24 * 60 * 60);

        $payload = [
            'id' => $active_user['id'],
            'role' => $active_user['role'],
            'iat' => $issuedAt,
            'exp' => $expirationTime
        ];

        $token = JWT::encode($payload, Config::JWT_SECRET(), 'HS256');

        Flight::json(['token' => $token]);
    }

    private function is_user_active($users)
    {
        foreach ($users as $user) {
            if (!isset($user['deleted']) || $user['deleted'] == 0) {
                return true;
            }
        }
        return false;
    }

    private function get_active_user($users)
    {
        foreach ($users as $user) {
            if (!isset($user['deleted']) || $user['deleted'] == 0) {
                return $user;
            }
        }
        return null;
    }
}
