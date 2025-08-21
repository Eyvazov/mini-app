# Mini App
<b>Quraşdırma</b> </br>
PHP versiyası - 8.1 <br>


<b>DB Bağlantısı</b> </br>
<ul>
<li>Verilənlər bazasının növü: MySQL</li>

<li>Host adı: localhost</li>

<li>İstifadəçi adı: root</li>

<li>Şifrə: (Boşdur)</li>

<li>Verilənlər bazasının adı: miniapp</li>
</ul>

<b>DB SQL</b> </br>
<code>CREATE TABLE registrations (
id INT AUTO_INCREMENT PRIMARY KEY,
full_name VARCHAR(120) NOT NULL,
email VARCHAR(120) NOT NULL UNIQUE,
company VARCHAR(120),
created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);</code>


<b>DB və SMTP parametrlərinin yazılmalı olduğu fayl</b> </br>
/config/config.php


<b>İşlətmə Linkləri</b> </br>
<ul>
<li>Qeydiyyat Formu - "/"</li>
<li>Admin Login və Qeydiyyat Sıyahısı - "/list"</li>
</ul>