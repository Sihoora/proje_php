<?php
            if(isset($_POST['ayar_buton'])) {
                $kadi = trim($_POST['kadi']);
                $mevcut_sifre = trim($_POST['mevcut_sifre']);
                $yeni_sifre = trim($_POST['yeni_sifre']);
                $sifre_tekrar = trim($_POST['sifre_tekrar']);
                $kadiGuncellendi = false;
                $sifreGuncellendi = false;

                if(!$kadi || !$mevcut_sifre) {
                    echo "<script>
                                Swal.fire({
                                    title: 'Başarısız',
                                    text: 'Kullanıcı Adı Ve Şifre Boş Bırakılamaz',
                                    icon: 'error'
                                });
                            </script>";
                } else {
                    $id = $_SESSION['id'];
                    $query = $db->query("SELECT * FROM hesaplar WHERE id = $id && sifre = '$mevcut_sifre'");
                    if($query->rowCount() > 0) {
                     if($yeni_sifre != "") {
                        if($yeni_sifre == $sifre_tekrar){
                         $update = $db->prepare("UPDATE hesaplar SET kadi = ?, sifre = ? WHERE id = ?");
                         $update->execute([$kadi, $yeni_sifre, $id]);
                         if(!$update) {
                                echo "<script>
                                    Swal.fire({
                                        title: 'HATA!',
                                        text: 'Şifreniz güncellemedi',
                                        icon: 'error'
                                    });
                                </script>";
                         } else {
                            $sifreGuncellendi = true;
                                    echo "<script>
                                        Swal.fire({
                                            title: 'Başarılı',
                                            text: 'Şifreniz Güncellendi',
                                            icon: 'success'
                                        });
                                    </script>";
                         }
                        } else {
                            echo "<script>
                                Swal.fire({
                                    title: 'HATA!',
                                    text: 'Girdiğiniz Şifreler Aynı Değil',
                                    icon: 'error'
                                });
                            </script>";
                        }
                       } else {
                            if($kadi != $_SESSION['kadi']) {
                                $update2 = $db->prepare("UPDATE hesaplar SET kadi = ? WHERE id = ?");
                                $update2->execute([$kadi, $id]);
                                if(!$update2) {
                                    echo "<script>
                                        Swal.fire({
                                            title: 'HATA!',
                                            text: 'Kullanıcı adınız güncellenemedi',
                                            icon: 'error'
                                        });
                                    </script>";
                                } else {
                                    $kadiGuncellendi = true;
                                    $_SESSION['kadi'] = $kadi;
                                }
                            }
                            $mesaj = "";
                            if($kadiGuncellendi == true) {
                                $mesaj .= "Kullanıcı Adınız Guncellendi";
                            }
                            if($sifreGuncellendi == true) {
                                $mesaj .= "Sıfreniz Guncellendi";
                            }
                            echo "<script>
                                Swal.fire({
                                    title: 'Başarılı!',
                                    text: '$mesaj',
                                    icon: 'success'
                                });
                            </script>";
                            header("Refresh:2; url=admin.php");
                       }
                    } else {
                        echo "<script>
                            Swal.fire({
                                title: 'HATA!',
                                text: 'Mevcut Şifreniz Hatalı',
                                icon: 'error'
                            });
                        </script>";
                    }
                } 
            }
            
            ?>

<form class="ziyaretci_form" action="" method="post">
    <h4>Bilgilerinizi Güncelleyin</h4>
    <label>
        <span>Kullanıcı Adı *</span>
        <input type="text" name="kadi" value="<?php echo $_SESSION['kadi']; ?>">
    </label>
    <label>
        <span>Mevcut Şifre *</span>
        <input type="password" name="mevcut_sifre">
    </label>
    <label>
        <span>Yeni Şifre</span>
        <input type="password" name="yeni_sifre">
    </label>
    <label>
        <span>Şifre Tekrar</span>
        <input type="password" name="sifre_tekrar">
    </label>
    <label>
        <button type="submit" class="submit-btn" name="ayar_buton">Bilgileri Güncelle</button>
    </label>
    <br>
    <label>
        <small style="text-align:center;">Bilgilerini Güncellemek İçin Mevcut Şifrenizi Girmelisiniz.</small>
    </label>
</form>