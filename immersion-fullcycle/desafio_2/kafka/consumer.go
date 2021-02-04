package kafka

import (
	"fmt"

	ckafka "github.com/confluentinc/confluent-kafka-go/kafka"
)

type KafkaConsumer struct {
}

func NewKafkaConsumer() *KafkaConsumer {
	return &KafkaConsumer{}
}

func (k *KafkaConsumer) Consume() {
	configMap := &ckafka.ConfigMap{
		"bootstrap.servers": "kafka:9092",
		"group.id":          "consumergroup",
		"auto.offset.reset": "earliest",
	}
	c, err := ckafka.NewConsumer(configMap)

	if err != nil {
		panic(err)
	}

	topics := []string{"test"}
	c.SubscribeTopics(topics, nil)

	fmt.Println("kafka consumer has been started")
	for {
		msg, err := c.ReadMessage(-1)
		if err == nil {
			fmt.Println(string(msg.Value))
		}
	}
}
