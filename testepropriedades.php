<?php
    require_once 'propriedades.php';
    $oPropriedades = new propriedades();

    $oPropriedades->setPropriedadeString(chave: "AUTOR", valor: "Ricardo Erick Rebêlo");
    echo nl2br(string: "AUTOR: " . $oPropriedades->getPropriedadeString(chave: "autor", default: "<>") . "\n");

    $oPropriedades->setPropriedadeString(chave: "CLASSE", valor: "propriedades");
    echo nl2br(string: "CLASSE: " . $oPropriedades->getPropriedadeString(chave: "CLASSE", default: "<>") . "\n");

    $oPropriedades->setPropriedadeString(chave: "VERSÃO", valor: "0.1");
    echo nl2br(string: "VERSÃO: " . $oPropriedades->getPropriedadeString(chave: "VERSÃO", default: "<>") . "\n");

    $oPropriedades->setPropriedadeFloat(chave: "1/3", valor: 1/3);
    echo nl2br(string: "1/3: " . $oPropriedades->getPropriedadeFloat(chave: "1/3") . "\n");

    $oPropriedades->setPropriedadeBool(chave: "VERDADEIRO", valor: true);
    echo nl2br(string: "VERDADEIRO: " . 
              ($oPropriedades->getPropriedadeBool(chave: "VERDADEIRO") ? "verdadeiro" : "falso") . "\n");
