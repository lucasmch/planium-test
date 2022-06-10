<?php
if (isset($_POST['btnConfirm'])) { #VERIFICA SE HOUVE O METHODO POST
    /* LIMPAR VARIAVEIS */
    $planSelected = intval(htmlspecialchars($_POST['planSelected']));
    $beneficiariesQuantity = intval(htmlspecialchars($_POST['beneficiariesQuantity']));
    $beneficiariesName = array_map("htmlspecialchars", $_POST['beneficiariesName']);
    $beneficiariesAge = array_map("htmlspecialchars", $_POST['beneficiariesAge']);
    

    $planData = getPlan($planSelected);
    if (!$planData) { #VERIFICA SE O NÃO PLANO EXISTE
        echo "NÃO EXISTE O PLANO";
    }
    if ($beneficiariesQuantity <= 0) { #VERIFICA SE NÃO TEM PARTICIPANTES 
        echo "SEM CLIENTES";
    }

    /* SALVAR BENEFICIARIOS.JSON */
    $beneficiariesJson = new stdClass();
    $beneficiariesJson->plano = $planData->nome;
    $beneficiariesJson->quantidade = $beneficiariesQuantity;
    for ($i = 0; $i < $beneficiariesQuantity; $i++) {
        $beneficiariesJson->beneficiarios[] = array(
            "nome"=>$beneficiariesName[$i],
            "idade"=>intval($beneficiariesAge[$i])
        );
    }
    file_put_contents('../assets/results/beneficiarios.json', json_encode($beneficiariesJson));


    /* SALVAR PROPOSTA.JSON */
    $price = getPrice($planSelected, $beneficiariesQuantity);
    $propostaJson = new stdClass();
    $totalValue = 0;
    $propostaJson->ValorTotal = $totalValue;
    for ($i = 0; $i < $beneficiariesQuantity; $i++) {
        if ($beneficiariesAge[$i] < 0 ) {
            echo "IDADE INVALIDA";
        } elseif ($beneficiariesAge[$i] <= 17) {
            $valor = intval($price->faixa1);
        } elseif ($beneficiariesAge[$i] <= 40) {
            $valor = intval($price->faixa2);
        } elseif ($beneficiariesAge[$i] > 40) {
            $valor = intval($price->faixa3);
        }

        $propostaJson->beneficiarios[] = array(
            "plano"=>$planData->nome,
            "nome"=>$beneficiariesName[$i],
            "idade"=>intval($beneficiariesAge[$i]),
            "valor"=>$valor
        ); 
        $totalValue = $totalValue + $valor;
    }
    $propostaJson->ValorTotal = $totalValue;
    file_put_contents('../assets/results/proposta.json', json_encode($propostaJson));

    /* FINALIZAR E MANDAR PARA PAGINA FINAL */
    header("Location: ../final.html");
    die();
}

function getPlan($plan) {
    /* CARREGAR ARQUIVOS JSON */
    $jsonPlans = file_get_contents("../assets/jsons/plans.json");
    $plans = json_decode($jsonPlans);

    $hasPlan = false;
    foreach ($plans as $key => $value) { #PERCORRE CADA PLANO
        if ($value->codigo == $plan) {
            $hasPlan = $plans[$key];
        }
    }
    return $hasPlan;
}

function getPrice($cod, $quantity) {
    /* CARREGAR ARQUIVOS JSON */
    $jsonPrices = file_get_contents("../assets/jsons/prices.json");
    $prices = json_decode($jsonPrices);

    foreach ($prices as $key => $value) { #PERCORRE CADA PLANO
        if ($value->codigo == $cod) {
            if($value->minimo_vidas <= $quantity) {
                if(isset($price)) {
                    if($value->minimo_vidas > $price->minimo_vidas) {
                        $price = $prices[$key];
                    }
                } else {
                    $price = $prices[$key];
                }
            }
        }
    }
    return $price;
}
?>
