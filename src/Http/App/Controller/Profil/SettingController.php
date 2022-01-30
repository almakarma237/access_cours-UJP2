<?php


namespace App\Http\App\Controller\Profil;


use App\Application\Auth\Command\SettingCommand;
use App\Application\Auth\Dto\UtilisateurDto;
use App\Domain\Auth\Entity\Utilisateur;
use App\Http\Form\Profil\EmailSettingType;
use App\Http\Form\Profil\GeneralSettingType;
use App\Http\Form\Profil\PasswordSettingType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @author Elessa Maxime <elessamaxime@icloud.com>
 * @package App\Http\App\Controller\Profil
 * @IsGranted("IS_AUTHENTICATED_FULLY")
 */
class SettingController extends AbstractController
{

    private SettingCommand $command;

    public function __construct(SettingCommand $command)
    {
        $this->command = $command;
    }

    /**
     * @Route("/profil/setting/{id}", name="app_profil_setting")
     * @param Utilisateur $user
     * @param Request $request
     * @return Response
     */
    public function index(Utilisateur $user, Request $request) : Response
    {
        $userDto = new UtilisateurDto($user);

        $userDto->email = "";
        $generalSetting = $this->createForm(GeneralSettingType::class, $userDto);
        $emailSetting = $this->createForm(EmailSettingType::class, $userDto);
        $passwordSetting = $this->createForm(PasswordSettingType::class, $userDto);

        $this->generalSetting($generalSetting, $userDto, $request);
        $this->emailSetting($emailSetting, $userDto, $request);
        $this->passwordSetting($passwordSetting, $userDto, $request);

        return $this->render("profil/setting.html.twig",[
            "generalSetting" => $generalSetting->createView(),
            "emailSetting" => $emailSetting->createView(),
            "passwordSetting" => $passwordSetting->createView(),
        ]);
    }

    private function generalSetting(FormInterface $form, UtilisateurDto $utilisateurDto, Request $request)
    {
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $this->command->updateGeneralSetting($utilisateurDto);
            return $this->redirectToRoute("app_profil_setting", ["id" => $utilisateurDto->id]);
        }
        return false;
    }

    private function emailSetting(FormInterface $form, UtilisateurDto $utilisateurDto, Request $request)
    {
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $this->command->updateEmail($utilisateurDto);
            return $this->redirectToRoute("app_profil_setting", ["id" => $utilisateurDto->id]);
        }
        return false;
    }

    private function passwordSetting(FormInterface $form, UtilisateurDto $utilisateurDto, Request $request)
    {
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $this->command->updatePassword($utilisateurDto);
        }
    }

}