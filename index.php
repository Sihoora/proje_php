<?php require_once 'vt.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <title>Ziyaretçi Kayıt Defteri</title>
    <link rel="stylesheet" href="index.css">

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

    
</head>

<body>

    <form class="ziyaretci_form" action="" method="post">
        <h4>Ziyaretçi Defteri</h4>
        <?php 
            if(isset($_POST['mesaj_gonder'])) {
                $ad = trim($_POST['ad']);
                $soyad = trim($_POST['soyad']);
                $email = trim($_POST['email']);
                $mesaj = trim($_POST['mesaj']);


                if(!$ad || !$soyad || !$email || !$mesaj) {
                    echo "Lütfen Tüm Alanları Doldurun";
                } else {
                    if(filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
                        echo "Lütfen Gecerli Bir Mail Adresi Girin";
                    }else {
                        $insert = $db ->prepare("INSERT INTO mesajlar SET
                            ad_soyad = ?,
                            email = ?,
                            mesaj = ?");
                            $insert->execute([$ad." ".$soyad, $email, $mesaj]);
                            if($db->LastInsertId()) {
                                echo "<script>
                                Swal.fire({
                                    title: 'Başarılı',
                                    text: 'Mesajınız Gönderildi',
                                    icon: 'success'
                                });
                            </script>";
                            header("Refresh:1; url=index.php");
                            }else {
                                echo "<script>
                                Swal.fire({
                                    title: 'Hata',
                                    text: 'Mesajınız Gönderilemiyor',
                                    icon: 'error'
                                });
                            </script>";

                        }
                    }
                }
            }
        
        
        
        
        
        
        
        
        
        
        ?>
        <label>
            <span>Adiniz</span>
            <input type="text" name="ad">
        </label>
        <label>
            <span>Soyadiniz</span>
            <input type="text" name="soyad">
        </label>
        <label>
            <span>Email Adresiniz</span>
            <input type="text" name="email">
        </label>
        <label>
            <span>Mesajiniz</span>
            <textarea name="mesaj"></textarea>
        </label>
        <label>
            <button type="submit" class="submit-btn" name="mesaj_gonder">Mesajı Gönder</button>
        </label>


    </form>



















</body>

</html>