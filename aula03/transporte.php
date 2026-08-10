<?php
    $trans = $_GET['transporte'];
    $trans = trim(strtolower($trans));

    if($trans == 'carro')
        echo '<img style="width:500px; height:300px" src="https://img.magnific.com/psd-gratuitas/carro-isolado-preto_23-2151852894.jpg?semt=ais_test_b&w=740&q=80"/>';
    else if($trans == 'moto')
        echo '<img style="width:500px; height:300px" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSPyR-bgO-TkWmc4Il7tuBij54bp2JRKgmok9W4WF8ffzOCVSifo1VOmtrp&s=10"/>';
    else if($trans == 'bicicleta')
        echo '<img style="width:500px; height:300px" src="https://m.media-amazon.com/images/I/81EKX7fd-PL._AC_UF1000,1000_QL80_.jpg"/>';
    else if($trans == 'navio')
        echo '<img style="width:500px; height:300px" src="https://www.portosenavios.com.br/images/220824-msc-cruzeiro-Seascape.jpg"/>';
    else if($trans == 'aviao')
        echo '<img style="width:500px; height:300px" src="https://png.pngtree.com/thumb_back/fh260/background/20230704/pngtree-3d-rendered-and-illustrated-view-of-airplane-s-front-image_3758189.jpg"/>';
    else
        echo 'Digite um transporte válido ou disponível'
?>