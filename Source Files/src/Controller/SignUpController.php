<?php
/**
 * Created by PhpStorm.
 * User: natalie
 * Date: 27.09.2017
 * Time: 10:31
 */

class SignupController extends Controller {

    /**
     * @Route("/signup", name="signup")
     */
    public function signupAction(Request $request, UserPasswordEncoderInterface $passwordEncoder) {
        $user = new User();
        $error = "";
        $form = $this->createFormBuilder($user)
            ->setMethod('POST')
            ->add('username', TextType::class)
            ->add('password', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options' => array('label' => 'Password'),
                'second_options' => array('label' => 'Repeat password')))
            ->add('save', SubmitType::class, array('label' => 'Signup'))
            ->getForm()
        ;
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->get('doctrine')->getManager();
            $user = $form->getData();
            // check if username is already taken
            $query = $em->createQuery('SELECT u FROM AppBundle:User u WHERE u.username = ?1');
            $query->setParameter(1, $user->getUsername());
            $results = $query->getResult();

            if (empty($results)) {
                $password = $passwordEncoder->encodePassword($user, $user->getPassword());
                $user->setPassword($password);
                $user->setBlog($this->createBlogAction());
                $em->persist($user);
                $em->flush();

                return $this->redirectToRoute('login');
            }
            $error = "Username already taken";
        }
        return $this->render('signup.html.twig', [
            'title' => "Sign Up",
            'form' => $form->createView(),
            'error' => $error
        ]);
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
