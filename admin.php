<?php require_once 'vt.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <link rel="stylesheet" href="index.css">
    <style>
        table.mesajlar {
            width: 820px;
            margin: 100px auto;
        }

        h4.baslik {
            display: block;
            text-align: center;
            margin-top: 100px;
            margin-bottom: 0px;
            font-size: 20px;
        }

        table.mesajlar td {
            border: 1px solid #ddd;
        }

        table.mesajlar img {
            width: 24px;
            height: 24px;
        }

        .butonlar {
            position: absolute;
            right: 25px;
            top: 25px;
        }

        .butonlar img {
            width: 60px;
            height: 60px;
            margin: 0px 7px;
        }
    </style>

    <script>
        // Silme işlemi SweetAlert kullanarak tetikleniyor
        function confirmDelete(id) {
            Swal.fire({
                title: 'Emin misiniz?',
                text: 'Bu mesajı silmek istediğinize emin misiniz?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Evet',
                cancelButtonText: 'Hayır'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Silme işlemi onaylandığında PHP kodunu tetikle
                    window.location.href = 'admin.php?islem=sil&id=' + id;
                }
            });
        }
    </script>

    <title>Ziyaretçi Yönetim</title>

</head>

<body>
    <?php
    if(isset($_SESSION['oturum']) && $_SESSION['oturum'] == true) {
        if(isset($_GET['islem'])) {
            switch($_GET['islem']) {
                case "cikis":
                    session_destroy();
                    header("Location:admin.php");
                break;
                case "sil":
                    if(isset($_GET['id'])) {
                        $delete = $db->prepare("DELETE FROM mesajlar WHERE id = ?");
                        $delete->execute([$_GET['id']]);
                        if($delete->rowCount() > 0) {
                            echo "<script>
                                Swal.fire({
                                    title: 'Başarılı',
                                    text: 'Mesajınız silindi',
                                    icon: 'success'
                                });
                            </script>";
                            header("Refresh=1; url=admin.php");
                        }else {
                            echo "<script>
                                Swal.fire({
                                    title: 'Hata',
                                    text: 'Mesaj silinemedi',
                                    icon: 'error'
                                });
                            </script>";
                        }
                    }
                break;
                case "ayarlar":
                    include_once "admin_ayarlar.php";
                    break;
            }
        } else {

        
    ?>

    
    <!-- Anasayfa -->
    <div class="butonlar">
        <a href="admin.php"><img src="geri.png" alt="Anasayfa"></a>
        <a href="admin.php?islem=ayarlar"><img src="ayarlar.png" alt="Ayarlar"></a>
        <a href="admin.php?islem=cikis"><img src="çıkış.png" alt="Çıkış Yap"></a>
    </div>
    <?php include_once "admin_anasayfa.php"; ?>
    <?php
        }
     } else {
        include_once "admin_giris.php";
     }
     
     ?>
 












</body>

</html>