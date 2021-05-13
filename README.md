# iHeros

O iHeros é um sistema que monitora as ameaças do mundo em tempo real. No sistema é possível cadastrar os heróis e suas localizações, assim o sistema aloca automaticamente os heróis para combater as ameaças.

## Tecnologias

- PHP 7.2
- CakePHP
- JavaScript
- NodeJS
- MYSQL
- AWS

## Experiência

Para a resolução do teste eu dividi o trabalho em duas frentes:

- Projeto (Backend e FrontEnd)
- Servidor (Infra)

### Projeto

Foi utilizado principalmente CakePHP, um framework da linguagem PHP. Iniciei desenvolvendo a parte de autenticação do sistema e os CRUD'S como cadastro de usuários, heróis e etc. A logica de alocação de batalhas entre ameaças e heróis e encerramento de batalhas foram criadas utilizando SHELL Script que é executado automaticamente pelo servidor. Por conta de uma limitação do PHP não foi possivel conectar ao socket https://zrp-challenge-socket.herokuapp.com (O PHP só aceita conexões ws:// ou wss://) então criei uma aplicação pequena utilizando NodeJS para se conectar ao socket. Quando essa aplicação recebe uma ocorrência ela dispara um POST para o PHP.

No Painel de controle as ocorrências são marcadas em um mapa (Google Maps API) e tudo acontece em tempo real. Isso é possível pois foi criado um WebSocket que monitora as ações como:

- Nova Ameaça
- Início de Batalha
- Encerramento de Batalha

Segue abaixo uma lista das funcionalidades do sistema:

- Login (autenticação)
- Lista, cadastra e altera usuários
- Lista, cadastra e altera heróis
- Painel de controle (com ações em tempo real)
- Lista Batalhas encerradas com status

### Servidor

Para demonstrar a parte de infra, todo o projeto está rodando em um servidor Linux criado a partir dos serviços AWS. O servidor foi criado utilizando o serviço EC2 e foi configurado com PHP-7.2 e NodeJS. Utilizei o modulo ZMQ e Supervisor do PHP para rodar o WebSocket que monitora os eventos no painel de controle. Para rodar a aplicação em node no background foi utilizado o módulo PM2.

### Serviços AWS

- EC2 - Para a configuração de um servidor cloud.
- RDS - Para a configuração do banco de dados MYSQL.
- Route 53 - Para redirecionamento do domínio.

## Teste e utilização

Para utilizar o software acesse a URL abaixo e explore as funcionalidades:

https://iheros.com.br

Usuário: zrp@teste.com.br
Senha: 123456

Espero que gostem :)

## Rodar localmente

Conforme solicitado foi adicionado na raiz do projeto um dump da base de dados com o nome iheros.sql e uma cópia da aplicação em NodeJS na pasta node_ameacas.

Para rodar o Websocket é necessário adicionar a extensão ZMQ ao PHP. Se estiver usando o PHP 7.2 copie e cole o arquivo libzmq.dll na raiz do PHP e o arquivo php_zmq.dll na pasta ext do PHP. Os dois arquivos estão na raiz do projeto, caso não esteja utilizando o PHP 7.2 será necessário fazer o download dos arquivos correspondentes a versão.

Depois de colar os dois arquivos .dll adicione a linha abaixo no arquivo php.ini

extension=php_zmq.dll

Para instalar as dependencias execute o comando abaixo na raiz do projeto. (Só íra funcionar se o composer estiver instalado globalmente, caso contrário utilize o caminho absoluto como mostra o exemplo abaixo)

```shell
composer install

// Exemplo caminho absoluto
C:\wamp64\bin\php\php7.2.33\php.exe C:\ProgramData\ComposerSetup\bin\composer.phar install
```
Para rodar o WebSocket execute o comando abaixo na raiz do projeto

```shell
bin\cake WebSocket

// Exemplo caminho absoluto
C:\wamp64\bin\php\php7.2.33\php.exe C:\wamp64\www\iheros\bin\cake.php WebSocket
```

Para rodar manualmente o script que inicia ou encerra as batalhas basta executar o comando abaixo na raiz do projeto

```shell
bin\cake Batalhas

// Exemplo caminho absoluto
C:\wamp64\bin\php\php7.2.33\php.exe C:\wamp64\www\iheros\bin\cake.php Batalhas

bin\cake Batalhas encerrar

// Exemplo caminho absoluto
 C:\wamp64\bin\php\php7.2.33\php.exe C:\wamp64\www\iheros\bin\cake.php Batalhas encerrar
```
