# gRPC

[source](https://www.youtube.com/watch?v=0MOtNXDmtSo&t=4265s)

## Protoc

```sh
protoc --go_out=application/gprc/pb --go_opt=paths=source_relative --go-grpc_out=application/grpc/pb --go-grpc_opt=paths=source_relative --proto_path=application/grpc/protofiles aplication/grpc/protofiles/*.proto
```

## Build

```sh
GOOS=linux go build -o superServer
```

## Cobra

For cli command line
