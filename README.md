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
git clone 
```
2. Entrar na pasta do projeto

3. Instalação dos containers

    *Obs.:* O docker-compose está preparado para subir o ambiente de desenvolvimento.
        Você pode popular o .env com os dados contidos nele :)
```
docker compose -f .docker/docker-compose.yaml up -d --build
```
4. Instalar dependências do projeto no container

5. Instalar dependências backend
```
docker exec -it app composer install
```
6.Instalar dependências frontend
```
docker exec -it app npm i
```
7.Rodar as migrations
```
docker exec -it app php vendor/bin/phinx migrate
```
8.Fazer o build do frontend
```
docker exec -it app npm run build
```
## Uso
