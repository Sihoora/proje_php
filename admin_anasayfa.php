<?php
    $query = $db->query("SELECT *, HOUR(tarih) as saat, MINUTE(tarih) as dakika,
    YEAR(tarih) as yil, MONTH(tarih) as ay, DAY(tarih) as gun FROM mesajlar ORDER BY id DESC");
    if($query->rowCount() > 0) {
    ?>
    <h4 class="baslik">Mesajlar</h4>
    <table class="mesajlar">
        <thead>
            <tr>
                <td>ID</td>
                <td>Ad Soyad</td>
                <td>Email</td>
                <td>Mesaj içeriği</td>
                <td>Tarih</td>
                <td>Islemler</td>
            </tr>
        </thead>
        <tbody>
            <?php 
             $result = $query->fetchALL(PDO::FETCH_ASSOC);
            // echo "<pre>",print_r($result),"</pre>";
            foreach($result as $row) {         
            ?>

            <tr>
                <td>
                    <?php echo $row['id']; ?>
                </td>
                <td>
                    <?php echo $row['ad_soyad']; ?>
                </td>
                <td>
                    <?php echo $row['email']; ?>
                </td>
                <td>
                    <?php echo $row['mesaj']; ?>
                </td>
                <td>
                    <?php echo $row['gun']."/".$row['ay']."/".$row['yil']." ".$row['saat'].":".$row['dakika']; ?>
                </td>
                <td>
                    <a href="admin.php?islem=sil&id=<?php echo $row['id']; ?>"> <img src="sil.png" alt="Sil"></a>
                    <a href="#"> <img src="geri.png" alt="Yanıtla"></a>
                </td>
            </tr>
            <?php } ?>

        </tbody>

    </table>
    <?php
    } else {
        echo "<script>
        Swal.fire({
            title: 'Dikkat',
            text: 'Hiç Mesaj Yok',
            icon: 'info'
        });
    </script>";
    }