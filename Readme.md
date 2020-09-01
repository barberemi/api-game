## Documentation
Des graphes de présentation sont présents ici : https://whimsical.com/Uci4ukJPBC8zvV8SjXoEkG
Le tableau des taches est présent ici : https://app.clickup.com/2603226/v/b/7-2603226-2

## Comment générer les clés de sécurité
- **(clé privée)** `openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096`
- **(clé publique)** `openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout`
- Mettre le passPhrase dans le fichier de configuration

Info : sur Windows, faire un "C:\Program Files\OpenSSL-Win64\bin\openssl.exe" au lieux de openssl.


## Lancer l'API
- s'assurer que son MySQL est bien lancé (WAMP ?)
- php bin/console server:run
- se rendre sur http://127.0.0.1:8000/api/doc
-
