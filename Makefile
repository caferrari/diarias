VERSION       = 0.1.13
SHELL        := $(shell which bash)
.SHELLFLAGS = -c

.SILENT: ;               # no need for @
.ONESHELL: ;             # recipes execute in same shell
.NOTPARALLEL: ;          # wait for this target to finish
.EXPORT_ALL_VARIABLES: ; # send all vars to shell
default: help-default;   # default target
Makefile: ;              # skip prerequisite discovery

help-default help:
	@echo "============================================"
	@echo "                          Options"
	@echo "============================================"
	@echo "                    test: Execute TDD tests"
	@echo ""

test:
	vendor/bin/phpunit --configuration module/Diarias/tests/phpunit.xml
