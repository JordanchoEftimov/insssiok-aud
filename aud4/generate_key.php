<?php
try {
    // Генерирање на 32 бајти случаен податок и конвертирање во хексадецимален формат
    echo bin2hex(random_bytes(32));  // random_bytes генерира случајни бајтови, bin2hex ги претвора во хексадецимален формат
} catch (Exception $e) {
    // Ако се појави грешка при генерирање на случајни податоци, прикажи порака за грешка
    echo "Error generating secret key";
}
