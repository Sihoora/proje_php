<?php
            if(isset($_POST['giris_buton'])) {
                $kadi = trim($_POST['kadi']);
                $sifre = trim($_POST['sifre']);
                if(empty($kadi) || empty($sifre)) {
                    echo "Lütfen Tüm Alanları Doldurun";
                } else {
                    $query = $db->prepare('SELECT * FROM hesaplar WHERE kadi = ? && sifre = ?');    
                    $query->execute([$kadi, $sifre]);
                    if($query->rowCount() > 0) {
                        $uye = $query->fetch(PDO::FETCH_OBJ);
                            $_SESSION['oturum'] = true;
                            $_SESSION['id'] = $uye->id;
                            $_SESSION['kadi'] = $uye->kadi;
                            header("Location:admin.php");
                            
                        } else {
                            echo "Kullanıcı Adı Veya Şifreniz Yanlış";                        
                    }
                
               }   
            
        }   
            
            ?>

    <form class="ziyaretci_form" action="" method="post">
        <h4>Lütfen Giriş Yapın</h4>
        <label>
            <span>Kullanıcı Adı</span>
            <input type="text" name="kadi">
        </label>
        <label>
            <span>Şifre</span>
            <input type="password" name="sifre">
        </label>
        <label>
            <button type="submit" class="submit-btn" name="giris_buton">Giriş Yap</button>
        </label>
    </form>
