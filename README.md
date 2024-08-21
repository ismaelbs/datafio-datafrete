# Calculadora de distância entre CEPs
<p align="center">Implementação do projeto proposto como desafio técnico por DATAFRETE</p>

---

## Tabela de Conteúdos

- [Descrição](#descrição)
- [Instalação](#instalação)
- [Uso](#uso)

## Descrição
O projeto **calculadora de distância  entre ceps** é uma aplicação criada para calcular a distância entre dois CEPs.

## Instalação
Para instalar o projeto, siga os seguintes passos:

1. Clone o repositório:
```
git clone https://github.com/ismaelbs/datafio-datafrete.git
```
2. Entrar na pasta do projeto

3. Instalação dos containers

*Obs.:* O docker-compose está preparado para subir o ambiente de desenvolvimento.
    Você pode popular o .env com os dados contidos nele :)
```
docker compose -f .docker/docker-compose.yaml up -d --build
```
4. Instalar dependências backend
```
docker exec -it app composer install
```
5.Instalar dependências frontend
```
docker exec -it app npm i
```
6.Rodar as migrations
```
docker exec -it app php vendor/bin/phinx migrate
```
7.Fazer o build do frontend
```
docker exec -it app npm run build
```
## Uso

### Workers
Para fazer uso da funcionalidade de importar csv é preciso iniciar os workers. Para fazer isso, usamos:
```
docker exec -it app php workers/worker.php
```
Podemos rodar esse comando mais de uma vez, para iniciar outros workers.
