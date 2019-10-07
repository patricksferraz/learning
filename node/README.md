# Learning Node

## General

```sh
# Init project
$ npm init [-y]
# Install module
$ npm install axios
```

## Async functions

### Callback

```js
/**
 * Simulating database
 */
function getUser(callBack) {
    setTimeout(() => {
        return callBack(null, {
            id: 1,
            name: 'Patrick',
            pass: '12345'
        })
    }, 2000)
}

/**
 * Callback function
 */
function resolveUser(error, result) {
    if (error) console.log(error)

    console.log(result)
}

// Call
getUser(resolveUser)
```

### Promise

```js
/**
 * Simulating database
 */
function getUser() {
    return new Promise((resolve, reject) => {
        setTimeout(() => {
            return resolve({
                id: 1,
                name: 'Patrick',
                pass: '12345'
            })
        }, 2000)
    })
}

// Calling and using promise return with .then
let usuario = getUser()
    .then(usuario => {
        console.log(usuario)
    })
    .catch(() => {
        console.log('Deu RUIM')
    })
```

### Promise with async|await

```js
/**
 * Simulating database
 */
function getUser() {
    return new Promise((resolve, reject) => {
        setTimeout(() => {
            return resolve({
                id: 1,
                name: 'Patrick',
                pass: '12345'
            })
        }, 2000)
    })
}

main()
/**
 * Best way to use the promise
 * async and await
 */
async function main() {
    try {
        const user = await getUser()

        /**
         * Nested Asynchronous Functions
         * const result = await Promise.all([
         *      ...
         *      signature of methods
         *      ...
         * ])
         */

        console.log(user)
    } catch (error) {
        console.log(error)
    }
}
```

## Events

### Event emitter

```js
const EventEmitter = require('events')

// class MeuEmissor extends EventEmitter {

// }

const meuEmissor = new EventEmitter() // | new MeuEmissor()
const nomeEvento = 'usuario:click'

// Can use the addListerner() function to listen to events
meuEmissor.on(nomeEvento, click => {
    console.log('um usuario clicou', click)
})

// Emitting event
meuEmissor.emit(nomeEvento, 'na barra de rolagem')
meuEmissor.emit(nomeEvento, 'no ok')
```

## Export modules

```js
// file: service.js
const axios = require('axios')
const URL = `https://swapi.co/api/people`

async function obterPessoas(nome) {
    const url = `${URL}/?search=${nome}&format=json`
    const response = await axios.get(url)
    return response.data
}

module.exports = {
    obterPessoas
}
```

## Lists handling

### For/ForIn/FotOf

See [Export modules](#export-modules)

```js
const service = require('./service')

async function main() {
    try {
        const result = await service.obterPessoas('a')
        const names = []

        // for (let i = 0; i < result.results.length; i++)
        // {
        //     const pessoa = result.results[i];
        //     names.push(pessoa.name)
        // }

        // for (let i in result.results)
        // {
        //     const pessoa = result.results[i];
        //     names.push(pessoa.name)
        // }

        for (pessoa of result.results) {
            names.push(pessoa.name)
        }

        console.log('names', names)
    } catch (error) {
        console.log('error interno', error)
    }
}

main()
```

### Map

```js
const service = require('./service')

async function main() {
    try {
        const result = await service.obterPessoas('a')

        // const names = []
        // result.results.forEach((item) => {
        //   names.push(item.name)
        // })

        const names = result.results.map(pessoa => {
            return pessoa.name
        })

        console.log('names', names)
    } catch (error) {
        console.log('error interno', error)
    }
}

main()
```

### Filter

```js
const { obterPessoas } = require('./service')

async function main() {
    try {
        const { results } = await obterPessoas('a')

        const larsFamily = results.filter(item => {
            return item.name.toLowerCase().indexOf('lars') !== -1
        })

        const namesLarsFamily = larsFamily.map(people => people.name)

        console.log('names', namesLarsFamily)
    } catch (error) {
        console.log('error interno', error)
    }
}

main()
```

### Reduce

```js
const { obterPessoas } = require('./service')

async function main() {
    try {
        const { results } = await obterPessoas('a')
        const pesos = results.map(item => parseInt(item.height))
        const total = pesos.reduce((previous, next) => {
            return previous + next
        }, 0)

        console.log('total', total)
    } catch (error) {
        console.log('error interno', error)
    }
}

main()
```

## Tests

### Mochajs

```js
// File: service.js
const { get } = require('axios')
const URL = 'https://swapi.co/api/people'

async function obterPessoas(nome) {
    const url = `${URL}/?search=${nome}&format=json`
    const response = await get(url)

    return response.data.results.map(mapearPessoas)
}

function mapearPessoas(item) {
    return {
        nome: item.name,
        peso: item.height
    }
}

module.exports = {
    obterPessoas
}
```

```js
// File: tests.js
const assert = require('assert')
const { obterPessoas } = require('./service')

describe('Star Wars tests', () => {
    it('deve buscar r2d2 com o formato correto', async () => {
        const expected = [{ nome: 'R2-D2', peso: '96' }]
        const nomeBase = 'r2-d2'
        const result = await obterPessoas(nomeBase)

        assert.deepEqual(result, expected)
    })
})
```

```sh
# exec mocha
$ mocha tests.js
```

### Simulating with nock

See [Mochajs](#mochajs)

```js
// File: tests.js

// ...

const nock = require('nock')

describe('Star Wars tests', () => {
    beforeEach(() => {
        // Simulating response of https://swapi.co/api/people/?search=r2-d2&format=json"
        const response = {
            count: 1,
            next: null,
            previous: null,
            results: [
                {
                    name: 'R2-D2',
                    height: '96',
                    mass: '32',
                    hair_color: 'n/a',
                    skin_color: 'white, blue',
                    eye_color: 'red',
                    birth_year: '33BBY',
                    gender: 'n/a',
                    homeworld: 'https://swapi.co/api/planets/8/',
                    vehicles: [],
                    starships: [],
                    created: '2014-12-10T15:11:50.376000Z',
                    edited: '2014-12-20T21:17:50.311000Z',
                    url: 'https://swapi.co/api/people/3/'
                }
            ]
        }

        nock('https://swapi.co/api/people')
            .get('/?search=r2-d2&format=json')
            .reply(200, response)
    })

    // ...
})
```

## Command line

```js
// File: index.js
const Commander = require('commander')
const Database = require('./database')
const Heroi = require('./heroi')

async function main(params) {
    Commander.version('v1')
        .option('-n, --nome [value]', 'Nome do heroi')
        .option('-p, --poder [value]', 'Poder do heroi')

        .option('-c, --cadastrar', 'Cadastrar um heroi')
        .parse(process.argv)

    const heroi = new Heroi(Commander)

    try {
        if (Commander.cadastrar) {
            delete heroi.id
            const resultado = await Database.cadastrar(heroi)
            if (!resultado) {
                console.error('Heroi não foi cadastrado')
                return
            }
            console.log('Heroi cadastrado com sucesso!')
        }
    } catch (error) {
        console.error('Deu ruim', error)
    }
}

main()

// terminal: node index.js -c -n Batman -p Money
```

```js
// File: database.js
const { readFile, writeFile } = require('fs')

const { promisify } = require('util')

const readFileAsync = promisify(readFile)
const writeFileAsync = promisify(writeFile)

class Database {
    constructor() {
        this.NOME_ARQUIVO = 'heroes.json'
    }

    async obterDadosArquivo() {
        const arquivo = await readFileAsync(this.NOME_ARQUIVO, 'utf8')
        return JSON.parse(arquivo.toString())
    }

    async escreverArquivo(dados) {
        await writeFileAsync(
            this.NOME_ARQUIVO,
            JSON.stringify(dados, null, '    ')
        )
        return true
    }

    async cadastrar(heroi) {
        const dados = await this.obterDadosArquivo()
        const id = heroi.id <= 2 ? heroi.id : Date.now()
        const heroiComId = {
            id,
            ...heroi
        }
        const dadosFinal = [...dados, heroiComId]
        const resultado = await this.escreverArquivo(dadosFinal)

        return resultado
    }
    // ...
}

module.exports = new Database()
```

```js
// File: heroi.js
class Heroi {
    constructor({ nome, poder, id }) {
        this.nome = nome
        this.poder = poder
        this.id = id
    }
}

module.exports = Heroi
```

## Sequelize (Postgres)

### Install sequelize and db drivers

```sh
# Sequelize
$ npm install sequelize
# Postgres drivers
$ npm install pg-hstore pg
```

### Usage

```js
const Sequelize = require('sequelize')
const driver = new Sequelize('heroes', 'patrickferraz', 's3nh4S3CR3T4', {
    host: 'localhost',
    dialect: 'postgres',
    quoteIdentifiers: false,
    operatorsAliases: false
})

async function main() {
    const Heroes = driver.define(
        'heroes',
        {
            id: {
                type: Sequelize.INTEGER,
                required: true,
                primaryKey: true,
                autoIncrement: true
            },
            nome: {
                type: Sequelize.STRING,
                required: true
            },
            poder: {
                type: Sequelize.STRING,
                required: true
            }
        },
        {
            tableName: 'TB_HEROES',
            freezeTableName: false,
            timestamps: false
        }
    )
    await Heroes.sync()
    // await Heroes.create()

    const result = await Heroes.findAll({ raw: true })

    console.log(result)
}

main()
```

## Mongoose (MongoDB)

### Install

```sh
$ sudo npm install mongoose
```

### Usage

```js
const Mongoose = require('mongoose')
Mongoose.connect(
    'mongodb://ferraz:minhasenhasecreta@localhost:27017/heroes',
    {
        useNewUrlParser: true
    },
    error => {
        if (!error) return

        console.log('Falha na conexão', error)
    }
)

const connection = Mongoose.connection
connection.once('open', () => console.log('database rodando!!!'))

// setTimeout(() => {
//     const state = connection.readyState
//     console.log('state', state)
//     /**
//      * 0: Desconectado
//      * 1: Conectado
//      * 2: Conectando
//      * 3: Desconectando
//      */
// }, 1000)

const heroesSchema = new Mongoose.Schema({
    nome: {
        type: String,
        required: true
    },
    poder: {
        type: String,
        required: true
    },
    insertedAt: {
        type: Date,
        default: new Date()
    }
})

const model = Mongoose.model('heroes', heroesSchema)

async function main() {
    const resultCadastrar = await model.create({
        nome: 'Batman',
        poder: 'Dinheiro'
    })
    console.log('result cadastrar', resultCadastrar)
}

main()
```

## API with Hapi.js

### Install

```sh
$ sudo npm i hapi
```

### Usage

```js
const Hapi = require('hapi')
const Context = require('./db/strategies/base/contextStrategy')
const MongoDb = require('./db/strategies/mongodb/mongoDbStrategy')
const HeroiSchema = require('./db/strategies/mongodb/schemas/heroSchema')

const app = new Hapi.Server({
    port: 5000
})

async function main() {
    const connection = MongoDb.connect()
    const context = new Context(new MongoDb(connection, HeroiSchema))

    app.route([
        {
            path: '/herois',
            method: 'GET',
            handler: (request, head) => {
                return context.read()
            }
        }
    ])

    await app.start()
    console.log('Servidor rodando na porta', app.info.port)
}

/**
 * Simulating request with Hapi
 * const result = await app.inject({
 *  method: 'GET',
 *  url: '...'
 * })
 * const result = await app.inject({
 *  method: 'POST',
 *  url: '...',
 *  payload: '...'
 * })
 */

main()
```

## Validating with Joi

### Install

```sh
$ sudo npm install joi
```

### Usage

Workes together with Hapi.js

```js
const Joi = require('joi')

// ...

async function main() {
    // ...

    app.route([
        {
            path: '/herois',
            method: 'GET',
            config: {
                validate: {
                    // payload -> body
                    // headers -> header
                    // params -> na URL :id
                    // query -> ?skip=10&limit=100

                    // Showes error detail
                    failAction: (request, headers, erro) => {
                        throw erro
                    }

                    query: {
                        skip: Joi.number().integer().default(0),
                        limit: Joi.number().integer().default(10),
                        nome: Joi.string().min(3).max(100)
                    }
                }
            }
            handler: (request, head) => {
                try {
                    const { skip, limit, nome } = request.query

                    // ...

                    // regex for MongoDb
                    const query = nome ? {nome: {$regex: `.*${nome}*.`}} : {}

                    return //db.read(query, skip, limit)

                }
                catch(error) {
                    console.error('Erro')
                    return 'Erro interno no sevidor'
                }
            }
        }
    ])

    // ...
}

main()
```

## Documenting with Swagger

### Install

```sh
$ sudo npm i vision inert hapi-swagger
```

### Usage

```js
// File: api.js
// ...

const Vision = require('vision')
const Inert = require('inert')
const HapiSwagger = require('hapi-swagger')

async function main() {
    // ...

    const swaggerOptions = {
        info: {
            title: 'Api name'
            version: 'Api version'
        },
        lang: 'Api lang'
    }
    app.register([
        Vision,
        Inert,
        {
            plugin: HapiSwagger,
            options: swaggerOptions
        }
    ])

    // ...
}

main()

// See: localhost:port/documentation

// -----------------------------------
// File: routes.js
{
    path: //...,
    method: // ...
    config: {
        tags: ['api'],
        description: 'Description message',
        notes: 'Notes'
        // ...
    }
    handler: // ...
}
```

## JSON Web Token (JWT)

## Credits

### Get the time

```js
console.time('for')
// ...
console.timeEnd('for')
```

### Destructing

```js
const array = [1, 2, 3, 4, 5]
const [a, b] = array // a = 1, b = 2
const [a, b, ...c] = array // a = 1, b = 2, c = [3, 4, 5]

const obj = { a: 1, b: 2, c: 3 }
const { a, b } = obj // a = 1, b = 2
const { a: first, b: second } = obj // first = 1, second = 2
const { a, d = 4 } = obj // a = 1, d = 4
const { a, c = 5 } = obj // a = 1, c = 3
```

### Create a new map

```js
Array.prototype.myMap = function(callBack) {
    const newArrayMaped = []

    for (let i = 0; i < this.length; i++) {
        const result = callBack(this[i], i)
        newArrayMaped.push(result)
    }

    return newArrayMaped
}
```

### Create a new filter

```js
Array.prototype.myFilter = function(callBack) {
    const newArrayFiltered = []

    for (index in this) {
        const item = this[index]
        const result = callBack(item, index, this)
        if (result) newArrayFiltered.push(item)
    }

    return newArrayFiltered
}
```

### Create a new reduce

```js
Array.prototype.myReduce = function(callBack, initial) {
    let end = typeof valorInicial !== undefined ? initial : this[0]

    for (let index = 0; index < this.length; index++) {
        end = callBack(end, this[index], this)
    }

    return end
}
```

### Mocha running automatically

```js
// package.json
//...
    "scripts": {
        "test": "mocha -w"
    }
// ...
```

```sh
$ npm t -w
```

### Element removing

```js
var myFish = ['angel', 'clown', 'mandarin', 'surgeon']
var removed = myFish.splice(2, 0, 'drum')
//myFish is ["angel", "clown", "drum", "mandarin", "surgeon"]
removed = myFish.splice(3, 1)
//myFish is ["angel", "clown", "drum", "surgeon"]
removed = myFish.splice(2, 1, 'trumpet')
//myFish is ["angel", "clown", "trumpet", "surgeon"]
```

### Search a string

```js
var str = 'Hello world, welcome to the universe.'
var n = str.indexOf('welcome') // 13
var n = str.indexOf('yellow') // -1
```

### Search index

```js
function isPrime(element, index, array) {
    var start = 2
    while (start <= Math.sqrt(element)) {
        if (element % start++ < 1) {
            return false
        }
    }
    return element > 1
}

console.log([4, 6, 8, 12].findIndex(isPrime)) // -1, not found
console.log([4, 6, 7, 12].findIndex(isPrime)) // 2
```

### Convert to int

```js
parseInt('1') // 1
```

### Docker

```sh
# List
$ sudo docker ps
# New container postgres
$ sudo docker run \
    --name postgres \
    -e POSTGRES_USER=patrickferraz \
    -e POSTGRES_PASSWORD=s3nh4S3CR3T4 \
    -e POSTGRES_DB=heroes \
    -p 5432:5432 \
    -d \
    postgres
# Enter the container
$ sudo docker exec -it postgres /bin/bash
# New container linked
$ sudo docker run \
    --name adminer \
    -p 8080:8080 \
    --link postgres:postgres \
    -d \
    adminer
# New container mongodb
$ sudo docker run \
    --name mongodb \
    -p 27017:27017 \
    -e MONGO_INITDB_ROOT_USERNAME=admin \
    -e MONGO_INITDB_ROOT_PASSWORD=s3nh4S3CR3T4 \
    -d \
    mongo:4
# New container mongoclient
$ sudo docker run \
    --name mongoclient \
    -p 3000:3000 \
    --link mongodb:mongodb \
    -d \
    mongoclient/mongoclient
# New user mongodb
$ sudo docker exec -it mongodb \
    mongo --host localhost -u admin -p s3nh4S3CR3T4 --authenticationDatabase admin \
    --eval "db.getSiblingDB('heroes').createUser({user: 'ferraz', pwd: 'minhasenhasecreta', roles: [{role: 'readWrite', db: 'heroes'}]})"
$ sudo docker ps
$ sudo docker exec -it mongodb \
    mongo -u ferraz -p minhasenhasecreta --authenticationDatabase heroes
```

### Scripts

```sql
/* postgres.sql */
DROP TABLE IF EXISTS TB_HEROES;
CREATE TABLE TB_HEROES (
    ID INT GENERATED ALWAYS AS IDENTITY PRIMARY KEY NOT NULL,
    NOME TEXT NOT NULL,
    PODER TEXT NOT NULL
);
-- CREATE
INSERT INTO TB_HEROES (NOME, PODER)
    VALUES
        ('Flash', 'Velocidade'),
        ('Aquaman', 'Falar com os animais'),
        ('Batman', 'Dinheiro');
-- READ
SELECT * FROM TB_HEROES;
SELECT * FROM TB_HEROES WHERE NOME = 'Flase';
-- UPDATE
UPDATE TB_HEROES
    SET NOME = 'Goku', PODER = 'Deus'
    WHERE ID = 1;
-- DELETE
DELETE FROM TB_HEROES WHERE ID = 2;

/* MongoDB */
show dbs -- see databases
use heroes -- alter context
show collections -- show tables (collections)
-- CREATE
db.heroes.insert({
    nome: 'flash',
    poder: 'velocidade',
    dataNascimento: '1998-01-01'
})
-- READ
db.heroes.find()
-- UPDATE
db.heroes.update({ _id: ObjectId('...')},
    {nome: 'Mulher maravilha'}) -- Deletes the other columns
db.heroes.update({ _id: ObjectId('...')},
    { $set {nome: 'Mulher maravilha'}}) -- Changes the specified column
-- DELETE
db.heroes.remove({}) -- All
db.heroes.remove({nome: 'Mulher maravilha'}) -- Just one
```

### Http.cat

Search status code

### Message customized with Boom

```sh
# Install
$ sudo npm install boom
```

```js
// Usage
const Boom = require('boom')
try {
    // ...
} catch (error) {
    // ...
    return Boom.internal()
}
```
