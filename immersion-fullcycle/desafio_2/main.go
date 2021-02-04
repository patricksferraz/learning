package main

import (
	"fmt"

	ckafka "github.com/confluentinc/confluent-kafka-go/kafka"
	"github.com/patricksferraz/learning/immersion-fullcycle/desafio_2/kafka"
)

func main() {
	deliveryChan := make(chan ckafka.Event)
	producer, err := kafka.NewKafkaProducer()

	if err != nil {
		fmt.Println(err)
	}

	kafka.Publish("Hello World", "test", producer, deliveryChan)
	go kafka.DeliveryReport(deliveryChan)
	consumer := kafka.NewKafkaConsumer()
	consumer.Consume()
}
