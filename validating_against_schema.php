<?php

function libxml_display_error($error) {
  $return = "<br/>\n";
  switch ($error->level) {
    case LIBXML_ERR_WARNING:
      $return .= "<b>Warning $error->code</b>: ";
      break;
    case LIBXML_ERR_ERROR:
      $return .= "<b>Error $error->code</b>: ";
      break;
    case LIBXML_ERR_FATAL:
      $return .= "<b>Fatal Error $error->code</b>: ";
      break;
  }
  $return .= trim($error->message);
  if ($error->file) {
    $return .= " in <b>$error->file</b>";
  }
  $return .= " on line <b>$error->line</b>\n";
  return $return;
}

function libxml_display_errors() {
  $errors = libxml_get_errors();
  foreach ($errors as $error) {
    print libxml_display_error($error);
  }
  libxml_clear_errors();
}


if (!isset($argv[1]) || !isset($argv[2])) {
  echo "Hay que pasar el archivo con la ruta completa!";
  exit(1);
}

$xmlFile = $argv[1];

try{
  libxml_use_internal_errors(true);
  $library = new DOMDocument();
  if ($library->load($xmlFile)) {
    if ($library->schemaValidate($argv[2])) {
      echo "XML Valido!";
    } else {
      echo "ATENCION! -> XML NO VALIDO";
      libxml_display_errors();
      exit(1);
    }
  } else {
    echo "XML erroneo";
    libxml_display_errors();
  }


} catch (Exception $e) {
  echo "ATENCION! -> Problemas con el XSD";
  libxml_display_errors();
  exit(1);
}
exit(0);


 ?>
