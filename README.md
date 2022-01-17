# Konfiguracja środowiska

Najpierw należy wykonać lokalnie w konsoli komende:

```
git pull https://github.com/OsmanK98/task_php_january_2022.git
```

Następnie będąc w projekcie należy uruchomić komendę:

```
docker compose up -d --build
```

Po chwili projekt jest gotowy do testowania.
Jedyna rzecz jaką należy wykonać jest konfiguracja serwera poczty w pliku .env
```
MAILER_DSN=smtp://localhost
```
Sugeruje podpiąc MailTrapa lub odkomentować linijkę wyżej przykładową konfigurację serwera SMTP

## Komenda do wyświetlenia wszystkich albumów

Jako pierwszy argument należy podać **email**, jako drugi argument należy podać **hasło** uzytkownika, w celu autoryzacji

![img.png](assetsReadMe/im.png)

## Przykładowe requesty:

![img_1.png](assetsReadMe/img_1.png)

![img_2.png](assetsReadMe/img_2.png)

![img.png](assetsReadMe/img.png)

![img_3.png](assetsReadMe/img_3.png)

![img_4.png](assetsReadMe/img_4.png)

![img_5.png](assetsReadMe/img_5.png)

![img_6.png](assetsReadMe/img_6.png)

![img_7.png](assetsReadMe/img_7.png)

![img_8.png](assetsReadMe/img_8.png)

![img_9.png](assetsReadMe/img_9.png)

![img_10.png](assetsReadMe/img_10.png)
