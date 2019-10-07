#!/bin/zsh
path_py=/opt/anaconda3/envs/learning-deep-learning/bin/python

main() {
    for i in 1 2 3 4 5;
    do
    tensorflow $i
    keras $i
    done
}

tensorflow() {
    ${path_py} train_simple_nn.py -d animals -p "output/simple_nn_plot_$1.png" -m "output/simple_nn_$1.model" -l "output/simple_nn_lb_$1.pickle"
}

keras() {
    ${path_py} train_simple_nn_keras.py -d animals -p "output/simple_nn_plot_keras_$1.png" -m "output/simple_nn_keras_$1.model" -l "output/simple_nn_lb_keras_$1.pickle"
}

main
