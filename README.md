
# Desafio captação

Aqui utilizaremos scraping/crawling para capturar dados e o teste vai seguir essa mesma linha.

# Stack
  - **PHP**
    - Laravel
  - Banco de dados relacional
    - Mysql

# Objetivo
Desenvolver uma aplicação onde o será passado um código ou numero ISO 4217 (*padrão internacional que define códigos de três letras para as moedas*), e a aplicação deve consultar em uma fonte externa, os dados desta moeda.

- Fonte externa: [ISO 4217](https://pt.wikipedia.org/wiki/ISO_4217)
- A pesquisa pode ser feita com um ou mais items.
- Input de dados:  **Código ISO** valido ex: GBP ou um **número** ex: 826
```json
{  
  "code": "GBP"
}
```
OU 
```json
{  
  "code_list": ["GBP", "GEL", "HKD"]  
}
```
OU 
```json
{  
  "number": [242]  
}
```
OU
```json
{
  "number_lists": [242, 324]  
}
```
- Retorno esperado:
```json
[{  
  "code": "GBP",  
  "number": 826,  
  "decimal": 2,  
  "currency": "Libra Esterlina",  
  "currency_locations": [  
    {  
      "location": "Reuno Unido",  
      "icon": "https://upload.wikimedia.org/wikipedia/commons/thumb/a/ae/Flag_of_the_United_Kingdom.svg/22px-Flag_of_the_United_Kingdom.svg.png"  
    },  
    {  
      "location": "Ilha de Man",  
      "icon": ""  
    },  
    {  
      "location": "Guernesey",  
      "icon": ""  
    },  
    {  
      "location": "Jersey",  
      "icon": ""  
    }  
  ]  
}]  
```  
> Esses valores de entrada e saída são apenas exemplos, sinta se a vontade para melhorá-los.

## Observações:

- A tabela de dados da fonte não deve ser salva por inteiro no banco de dados.
- Utilizar a versão em português da página.
- Não precisa ter autenticação
