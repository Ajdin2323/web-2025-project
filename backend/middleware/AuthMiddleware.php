<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require_once dirname(__FILE__).'/../rest/Config.class.php';

class AuthMiddleware {
   public function verify_token($token){
       if(!$token)
           Flight::halt(401, $token);
       $decoded_token = JWT::decode($token, new Key(Config::JWT_SECRET(), 'HS256'));
       Flight::set('role', $decoded_token->role);
       Flight::set('jwt_token', $token);
       return TRUE;
   }

   public function authorize_role($requiredRole) {
       $role = Flight::get('role');
       if ($role !== $requiredRole) {
           Flight::halt(403, 'Access denied: insufficient privileges');
       }
   }

   public function authorize_roles($roles) {
       $role = Flight::get('role');
       if (!in_array($role, $roles)) {
           Flight::halt(403, 'Forbidden: role not allowed');
       }
   } 
}
