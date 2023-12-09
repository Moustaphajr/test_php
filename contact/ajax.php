<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

include "contact.class.php";

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {

    if (isset($_POST['action'])) {

        $contactManager = new ContactManager();


        $action = $_POST['action'] ?? '';

        switch ($action) {
            case 'addContact':
                $nom = $_POST['nom'];
                $prenom = $_POST['prenom'];
                $numero = $_POST['numero'];
                $email = $_POST['email'];

                $result = $contactManager->addContact($nom, $prenom, $numero, $email);

                header('Content-Type: application/json');
                echo json_encode(['success' => $result]);
                break;



            case 'getData':

                $result = $contactManager->getContacts();
                header('Content-Type: application/json');
                echo json_encode(['success' => $result]);
                break;

            case "filterData":


                $nom = $_POST['nom'];
                $prenom = $_POST['surname'];
                $result = $contactManager->filterContact($nom, $prenom);
                header('Content-Type: application/json');
                echo json_encode(['success' => $result]);

                break;




            case "deleteContact":
                $contactId = $_POST['contactId'];
                $result = $contactManager->deleteContact($contactId);
                header('Content-Type: application/json');
                echo json_encode(['success' => $result]);
                exit;


            case "EditContact":

                $contactId = isset($_POST['ContactId']) ?? null;
                $nom = $_POST['nom'] ?? null;
                $prenom = $_POST['prenom'] ?? null;
                $numero = $_POST['numero'] ?? null;
                $email = $_POST['email'] ?? null;

                $result = $contactManager->EditContact($contactId, $nom, $prenom, $numero, $email);
                header('Content-Type: application/json');
                echo json_encode(['success' => $result]);
                break;




            default:
                // Action non supportée
                header('Content-Type: application/json');
                echo json_encode(['error' => 'Invalid action']);
                break;
        }
    }
}
