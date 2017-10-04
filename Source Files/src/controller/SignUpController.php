<?php

class SignupController extends Controller {


    public function signupAction(Request $request, UserPasswordEncoderInterface $passwordEncoder) {

    }

    function setSaltedHash($password) {
        $pepper     = "NatAnA";
        $salt       = mcrypt_create_iv(22, MCRYPT_DEV_URANDOM);
        //salt noch in DB speichern!
        $saltpepper = $salt + $pepper;
        $options    = [
            'salt' => $saltpepper
            //    $salt = uniqid(mt_rand(), true);
        ];
        return password_hash($password, PASSWORD_BCRYPT, $options);
    }

}
