<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planium - Registrar</title>
    <link rel="icon" type="image/x-icon" href="assets/images/favicon.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/styles.css">
</head>

<body>
    <div class="container container">
        <div class="row row-register column-reverse d-flex">
            <div class="col-12 col-xl-7 d-flex align-self-xl-center justify-content-xl-center flex-column">
                <h1 class="title-bene">Solicite seu Plano de Saúde</h1>

                <form class="register-form" action='./confirm.php' method='POST'>
                    <div class="bene mb-2 mt-4">
                        <h5>Planos:</h6>
                            <div class="row mb-3">
                                <select class="form-select" name="planSelected">
                                    <?php  /* CARRGAR PLANOS NO SELECT */
                                        $jsonPlans = file_get_contents("../assets/jsons/plans.json"); /* PEGAR O ARQUIVO JSON */
                                        $plans = json_decode($jsonPlans); /* DECODIFICAR */

                                        foreach ($plans as $key => $value) { /* PARA CADA PLANO */
                                            echo "<option value='{$value->codigo}'>{$value->nome}</option>"; /* CRIAR UM SELECT */
                                        }

                                    ?>
                                    
                                </select>
                            </div>
                    </div>

                    <?php
                    if (isset($_POST['btnRegister'])) { /* VERIFICA SE HOUVE O METHODO POST */
                        if (isset($_POST['quantity'])) { /* VEFICA SE É 1 OU MAIS PARTICIPANTES */
                            $quantity = intval(htmlspecialchars($_POST['quantity']));
                            for ($i = 1; $i <= $quantity; $i++) { /* MOSTRA A QUANTIDADE DE FORMS DE ACORDO COM A QUANTIDADE DE PARTICIPANTES */
                                echo "<div class='bene mb-4'> <h5>Dados do {$i}º beneficiário</h6> <div class='row form-floating mb-3'> <input type='text' class='form-control' id='name' name='beneficiariesName[]' placeholder='Nome Completo' required minlength='3'> <label for='name'>Nome e Sobrenome</label> </div> <div class='row form-floating mb-3'> <input type='number' class='form-control' id='age' name='beneficiariesAge[]' placeholder='Idade' min='1' required> <label for='age'>Idade</label> </div> </div>";
                            }
                            echo "<input type='number' style='display: none' name='beneficiariesQuantity' value='{$quantity}'> ";
                        } else { /* MOSTRA SOMENTE PARTICIPANTE */
                            echo '<div class="bene mb-4"> <h5>Dados do beneficiário</h6> <div class="row form-floating mb-3"> <input type="text" class="form-control" id="name" name="beneficiariesName[]" placeholder="Nome Completo" required minlength="3"> <label for="name">Nome e Sobrenome</label> </div> <div class="row form-floating mb-3"> <input type="number" class="form-control" id="age" name="beneficiariesAge[]" placeholder="Idade" min="1" required> <label for="age">Idade</label> </div> </div>';
                            echo "<input type='number' style='display: none' name='beneficiariesQuantity' value='1'> ";
                        }
                    } else { /* CASO ELE ENTRE NA PAGINA DE REGISTROS SEM AS INFOS ELE VOLTA PARA O INDEX PARA ESCOLHER */
                        header("Location: ../index.html");
                        die();
                    }
                    ?>
                    <div class="row mb-3">
                        <button type="submit" name="btnConfirm" class="btn btn-success form-btn">Confirmar</button>
                    </div>
                </form>
            </div>
            <div class="col-12 col-xl-5 d-flex align-self-xl-end justify-xl-content-end align-self-start justify-content-center">
                <img src="../assets/images/background2.png" alt="Image for background" class="image-background ">
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-kjU+l4N0Yf4ZOJErLsIcvOU2qSb74wXpOhqTvwVx3OElZRweTnQ6d31fXEoRD1Jy" crossorigin="anonymous"></script>
</body>

</html>