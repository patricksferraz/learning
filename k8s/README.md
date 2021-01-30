# live-k8s-esqueta-imersao

## Stress test

```sh
kubectl run -it --generator=run-pod/v1 fortio --rm --image=fortio/fortio -- load -qps 900 -t 100s -c 70 "http://hotserver-service/"
```
