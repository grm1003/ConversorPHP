<!DOCTYPE html>
<html>
<head>
    <title>Aprendendo PHP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form action="" method="POST" class="col-sm-12 col-md-8 col-xl-6 container center box-input">
            <div class="form-floating mb-3"> 
                <input type="text" class="form-control" id="valor" name="valor" placeholder="0.00">
                <label for="floatingInput">Valor a ser convertido</label>
            </div>
            <div class="form-floating">
                <!-- <label>Selecione a moeda atual</label> -->
                <select id="atual" name="moeda" class="form-select" aria-label="Default select example">
                    <option value="0"selected></option>
                    <option value="1">Real</option>
                    <option value="2">Dolar</option>
                </select>
            </div>
            <div class="form-floating">
                
                <select id="convertido" name="moeda1"  class="form-select" aria-label="Default select example">
                    <option value="0"selected></option>
                    <option value="1">Real</option>
                    <option value="2">Dolar</option>
                </select>
              <!--   <label >Selecione a moeda a ser convertida</label> -->
            </div>
            <div class="d-flex justify-content-center">
            <input class="botao" type="submit" value="Converter"/>
            </div>
    </form>
    




<?php
    session_start();
        require_once "conexao.php";
    
        $conn = new Conexao();
        if ($_SERVER["REQUEST_METHOD"] === "POST" &&  $_POST['moeda1'] != 0 && $_POST['moeda'] != 0 && !empty($_POST['valor'])) {


        $moeda = $_POST['moeda'];
        $moeda1 = $_POST['moeda1'];
        $valor = $_POST['valor'];
        $sql = "SELECT * FROM cotacao WHERE idmoeda = ? and idmoeda1 = ?";
        $stmt = $conn->conexao->prepare($sql);
        $stmt->bindParam(1,$moeda);
        $stmt->bindParam(2, $moeda1);
        $resultado = $stmt->execute();

        if ($resultado === TRUE && $stmt->rowCount() == 1) {
                while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
                    $valorfinal = $rs->valor*$valor;
                }

         $sql = "SELECT simbolo FROM moeda WHERE idmoeda = ?";
            $stmt = $conn->conexao->prepare($sql);
            $stmt->bindParam(1,$moeda);
            $resultado = $stmt->execute();
            while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
                    $simbolo = $rs->simbolo;
            }

            $sql = "SELECT simbolo FROM moeda WHERE idmoeda = ?";
            $stmt = $conn->conexao->prepare($sql);
            $stmt->bindParam(1,$moeda1);
            $resultado = $stmt->execute();
            while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
                    $simbolo1 = $rs->simbolo;
            }
                echo '<div class="alert alert-success" role="alert">'.($simbolo).($valor)." equivale a ".($simbolo1).($valorfinal).'</div>';
           
        } else {
            echo '<div class="alert alert-danger" role="alert"> Não é possível fazer o cálculo.</div>';
        }
    }else {
        echo '<div class="alert alert-danger" role="alert"> Não é possível fazer o cálculo.</div>';
    }
?>
</body>
</html>