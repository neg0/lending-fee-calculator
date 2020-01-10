# Lendable Interview Test - Fee Calculation
I have used Linear Interpolation Equation to calculate the fee for loans according to given fee structure table given in the
assessment and created a relevant service named:
`LinearInterpolationFeeCalculatorService` which is written using TDD approach. Acceptance test to
satisfy the requirement of this assessment is located inside `tests` folder and test class is:
`LinearInterpolationFeeCalculatorServiceTest`.

However, for your convenience I also created a class named `Example` `(Example.php)` inside the root of `tests` folder
that could run as a test suit with real instantiation of parameters as per acceptance criteria illustrated in the original
assessment documentation.


## Architecture and Code Standards
I have utilised PSR 1/2 and Symfony coding guidelines to produce this solution. I followed the structure layed out in the
original assessment code. App is created using Domain-Driven Design (Anemic Domain Model) with latest OOP features of PHP7+
and implementation of SOLID principles. I have used TDD (BBD Styled) approach for creation of most of components, please
check the `tests` folder for the relevant tests.


## Up and Running with Docker & Makefile
Makefile is included to ease the running commands. Please run `make` at the root of the project to see the commands
you could use to run the tests on your host machine local or a php container.


### Docker
You could use Docker to run the tests, to simplify the commands, I created few aliases in `makefile` for your convenience.
In order to run the tests inside PHP container please run the command below:

    ~$: make docker-up
    ~$: make docker-test

if you wish to shutdown the PHP container after running the tests, please run the command below:

    ~$: make docker-down


### Local
You could also run the tests without docker, please ensure you have a PHP 7.1+ installed on your machine and then
fun the command below:

    ~$: make install
    ~$: make test


#### Credits
Hadi Tajallaei, January 2020
* [LinkedIn](https://www.linkedin.com/in/tajallaei)
* [Email](mailto:tajallaei@gmail.com)