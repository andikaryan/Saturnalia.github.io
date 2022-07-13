<?php 
    include "php/config.php";
    $new_url = "";
    if(isset($_GET)){
        foreach($_GET as $key=>$val){
            $u = mysqli_real_escape_string($conn, $key);
            $new_url = str_replace('/', '',$u);
        }
        $sql = mysqli_query($conn, "SELECT full_url FROM url WHERE shorten_url = '{$new_url}'");
        if(mysqli_num_rows($sql)>0){
            $count_query = mysqli_query($conn, "UPDATE url SET clicks = clicks+1 WHERE shorten_url = '{$new_url}'");
            if($count_query){
                $full_url = mysqli_fetch_assoc($sql);
            header("Location: ".$full_url['full_url']);
            }
        }
    }
?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saturnalia</title>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="wrapper">
        <form action="#" autocomplete="off">
        <input type="text" spellcheck="false" name="full_url" placeholder="Masukkan link" required>
        <i class="url-icon uil uil-link"></i>
        <button>Pendekkan</button>
        </form>
        <?php
            $sql2 = mysqli_query($conn, "SELECT * FROM url ORDER BY id DESC");
            if(mysqli_num_rows($sql2) > 0){;
        ?>
        <div class="count">
            <?php
                $sql3 = mysqli_query($conn, "SELECT COUNT(*) FROM url");
                $res = mysqli_fetch_assoc($sql3);

                $sql4 = mysqli_query($conn, "SELECT clicks FROM url");
                $total = 0;
                while($c = mysqli_fetch_assoc($sql4)){
                    $total = $c['clicks'] + $total;
                }
            ?>
            <span>Total Link: <span><?php echo end($res); ?></span> <br> Total Link Disalin: <span><?php echo $total; ?></span></span>
            <a href="php/delete.php?delete=all">Hapus semua</a>
        </div>
        <div class="urls-area">
            <div class="title">
                <li>Hasil</li>
                <li>Link Original</li>
                <li>Jumlah Disalin</li>
                <li></li>
            </div>
            <?php
            while($row = mysqli_fetch_assoc($sql2)){
                ?>
                <div class="data">
                <li>
                    <?php if("localhost/shortlink/" . strlen($row['shorten_url'])>50){
                        echo "localhost/shortlink/" . substr($row['shorten_url'], 0, 50);
                    }else{
                        echo "localhost/shortlink/" . $row['shorten_url'];
                    }
                    ?>
                </li>
                <li>
                    <?php if(strlen($row['full_url'])>65){
                            echo substr($row['full_url'], 0, 65);
                        }else{
                            echo $row['full_url'];
                        }
                    ?>
                </li>
                <li><?php echo $row['clicks']?></li>
                <li><a href="php/delete.php?id=<?php echo $row['shorten_url'] ?>">Hapus</a></li>
                </div>
                <?php
            }
        }
        ?>
        </div>
    </div>

    <div class="blur-effect"></div>
    <div class="popup-box">
        <div class="info-box">Pemendek link anda telah berhasil</div>
        <form action="#" autocomplete="off">
            <label>Edit link anda</label>
            <input type="text" class="shorten-url"spellcheck="false" value="">
            <i class="copy-icon uil uil-copy-alt"></i>
            <button>Simpan</button>
        </form>
    </div>













<script src="script.js"></script>
</body>
</html>