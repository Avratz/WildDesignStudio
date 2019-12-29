<?php


// configure
$from = 'Wild Design Studio <contacto@wilddesignstudio.com>';
$sendTo = 'Contacto Wild <contacto@wilddesignstudio.com>';
$subject = $_POST['asunto'];
$fields = array('nombre' => 'nombre', 'mail' => 'mail', 'mensaje' => 'mensaje'); // array variable name => Text to appear in email
$okMessage = 'Mensaje enviado! Gracias, nos contactaremos a la brevedad.';
$errorMessage = 'Hubo un error al tratar de enviar el mensaje. Intente nuevamente más tarde.';


// let's do the sending
if ($subject != "") {
    try
    {
        $emailText = "Mensaje nuevo de la página\n=============================\n";

        foreach ($_POST as $key => $value) {

            if (isset($fields[$key])) {
                $emailText .= "$fields[$key]: $value\n";
            }
        }

        mail($sendTo, $subject, $emailText, "From: " . $from);

        $responseArray = array('type' => 'success', 'message' => $okMessage);
    }
    catch (\Exception $e)
    {
        $responseArray = array('type' => 'danger', 'message' => $errorMessage);
    }

    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        $encoded = json_encode($responseArray);

        header('Content-Type: application/json');

        echo $encoded;
    }
    else {
        echo $responseArray['message'];
    }
}
?>
