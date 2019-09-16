<?php

class Validacao
{

  public static function email($email)
  {
    return !empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL);
  }

  public static function id($id)
  {
    return !empty($id) && filter_var($id, FILTER_VALIDATE_INT);
  }

  public static function telefone($telefone)
  {
    $len = strlen($telefone);
    return !empty($telefone) && ($len === 10 || $len === 11) && preg_match('/^.*[0-9].*$/', $telefone, $output_array);
  }

  // Créditos : https://www.codigofonte.com.br/codigos/validacao-de-cpf-com-php
  public static function cpf($cpf)
  {  // Verifiva se o número digitado contém todos os digitos
    $cpf = str_pad(ereg_replace('[^0-9]', '', $cpf), 11, '0', STR_PAD_LEFT);

    // Verifica se nenhuma das sequências abaixo foi digitada, caso seja, retorna falso
    if (strlen($cpf) != 11 || $cpf == '00000000000' || $cpf == '11111111111' || $cpf == '22222222222' || $cpf == '33333333333' || $cpf == '44444444444' || $cpf == '55555555555' || $cpf == '66666666666' || $cpf == '77777777777' || $cpf == '88888888888' || $cpf == '99999999999') {
      return false;
    } else {   // Calcula os números para verificar se o CPF é verdadeiro
      for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) {
          $d += $cpf{
            $c} * (($t + 1) - $c);
        }

        $d = ((10 * $d) % 11) % 10;

        if ($cpf{
          $c} != $d) {
          return false;
        }
      }

      return true;
    }
  }

  public static function senha($senha)
  {
    return !empty($senha) && strlen($senha) > 6;
  }

  public static function login($login)
  {
    return !empty($login) && !is_numeric($login[0]) && strlen($login) > 4;
  }
}
