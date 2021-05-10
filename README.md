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
