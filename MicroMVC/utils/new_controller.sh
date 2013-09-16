#!/bin/bash

echo "Please enter a controller name :"
read name

if [ -z $name ]
then
    printf "\e[31mError :No controller name entered\n\n\e[0m"
    exit
fi

# Make sure first letter is uppercase
first_char=${name:0:1}
if [[ $first_char == [a-z] ]]
then
    printf "\e[31mError :First character must be uppercase\n\n\e[0m"
    exit
fi

controller_template="<?php\n\tnamespace Matheos\\App;\n\n\tclass $name extends \\Matheos\\MicroMVC\Controller {\n\n\t}"
echo "Creating controller class...\n"
echo "$controller_template" > $name.php
mv $name.php ../../App/controllers/

model_fname=$name"Model"
model_template="<?php\n\tnamespace Matheos\\App;\n\n\tclass $model_fname extends \\Matheos\\MicroMVC\Model {\n\n\t}"
echo "Creating model class...\n"
echo "$model_template" > $model_fname.php
mv $model_fname.php ../../App/models/