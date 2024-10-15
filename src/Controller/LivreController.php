<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LivreController extends AbstractController
{

// src/Controller/FormController.php

    #[Route('/handle-form', name:"handle_form", methods:"POST")]
    public function handleForm(Request $request): JsonResponse
    {
        try {
            // Récupérer les données du formulaire
            $livre = $request->request->get('livre');
            $firstName = $request->request->get('first_name');
            $lastName = $request->request->get('last_name');
            $phoneNumber = $request->request->get('phone_number');

            // Construire le message à envoyer via Telegram
            $bookIcon = "📚";
            $phoneIcon = "📞";

            $message = sprintf(
                "%s Commande de livre: <b>%s</b>\n\n👤 Prénom: <b>%s</b>\n👤 Nom: <b>%s</b>\n%s Téléphone: <a href='tel:%s'>%s</a>",
                $bookIcon,
                htmlspecialchars($livre),
                htmlspecialchars($firstName),
                htmlspecialchars($lastName),
                $phoneIcon,
                $phoneNumber,
                $phoneNumber
            );

            // Envoyer le message via l'API Telegram
            $this->sendMessageToTelegram($message);

            // Préparer une réponse JSON pour le client
            $response = [
                'success' => true,
                'message' => 'Votre commande a bien été prise en charge. Merci !'
            ];
        } catch (\Exception $e) {
            // Gérer les erreurs et préparer une réponse d'échec
            $response = [
                'success' => false,
                'message' => 'Une erreur est survenue lors du traitement de votre commande.'
            ];
        }

        return new JsonResponse($response);
    }


    private function sendMessageToTelegram(string $message)
    {
        $botToken = '7798338068:AAF5S5eabQHzsRUAhFvvHbADouTjOO3wUFk'; // Remplacez par votre token
        $chatId = '7866341448'; // L'ID du chat ou du canal où vous voulez envoyer le message

        $url = sprintf(
            "https://api.telegram.org/bot%s/sendMessage",
            $botToken
        );

        $params = [
            'chat_id' => $chatId,
            'text' => $message,
            'parse_mode' => 'HTML' // Utilisation du format HTML
        ];

        // Faire une requête HTTP POST à l'API Telegram
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $output = curl_exec($ch);
        curl_close($ch);

        // Vous pouvez vérifier $output pour des erreurs si nécessaire
    }



    #[Route('/le-leadership-de-kirikou', name: 'app_kirikou')]
    public function kirikou(): Response
    {
        return $this->render('livre/kirikou.html.twig', [
            'controller_name' => 'LivreController',
        ]);
    }
     #[Route('/le-pouvoir-de-se-reveiller-tot', name: 'app_pouvoir')]
    public function pouvoir(): Response
    {
        return $this->render('livre/pouvoir.html.twig', [
            'controller_name' => 'LivreController',
        ]);
    }
}
