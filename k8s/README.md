# k8s

[source](https://www.youtube.com/watch?v=mnWEKcltpX0)

## Stress test

```sh
kubectl run -it --generator=run-pod/v1 fortio --rm --image=fortio/fortio -- load -qps 900 -t 100s -c 70 "http://hotserver-service/"
```
