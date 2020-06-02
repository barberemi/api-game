## Comment générer les clés de sécurité
- **(clé privée)** `openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096`
- **(clé publique)** `openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout`
- Mettre le passPhrase dans le fichier de configuration
