<?php

class LoginController extends Controller {

    /**
     * @Route("/login_check", name="login_check")
     */
    public function checkLoginAction() {
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction() {
    }

    /**
     * @Route("/login", name="login")
     */
    public function loginAcn(AuthenticationUtils $authUtils) {
        $error = $authUtils->getLastAuthenticationError();
        $lastUsername = $authUtils->getLastUsername();

        $user = new User();
        $form = $this->createFormBuilder($user)
            ->setAction($this->generateUrl('login_check'))
            ->add('username', TextType::class, array('property_path' => '_username'))
            ->add('password', PasswordType::class, array('property_path' => '_password'))
            ->add('save', SubmitType::class, array('label' => 'Login'))
            ->getForm()
        ;

        return $this->render('login.html.twig', [
            'title' => "Login",
            'form' => $form->createView(),
            'error' => $error,
            'last_username' => $lastUsername
        ]);
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => User::class,
        ));
    }

    public function loginAction($user, $password){

    }

    function checkPassword($password, $user){
        $compPassword = $user.get_password();
        $pepper       = "NatAnA";
        $salt         = $user.get_salt();
        $saltpepper   = $salt + $pepper;
        $options      = [
            'salt' => $saltpepper
            //    $salt = uniqid(mt_rand(), true);
        ];
        if($compPassword === password_hash($password, PASSWORD_BCRYPT, $options)){
            return true;
        } else {
            return false;
        }
    }

}