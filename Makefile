# SETTINGS
OK_COLOR   = \033[0;32m
WARN_COLOR = \033[0;33m
NO_COLOR   = \033[m

GREEN  := $(shell tput -Txterm setaf 2)
WHITE  := $(shell tput -Txterm setaf 7)
YELLOW := $(shell tput -Txterm setaf 3)
RESET  := $(shell tput -Txterm sgr0)

_COLOR									= \033[0;36m
_PREFIX									= $(_COLOR) =^_^= $(NO_COLOR)

HELP_FUN = \
    %help; \
    while(<>) { push @{$$help{$$2 // 'options'}}, [$$1, $$3] if /^([a-zA-Z\-_]+)\s*:.*\#\#(?:@([a-zA-Z\-_]+))?\s(.*)$$/ }; \
    print "usage: make app=[app] [target]\n\n"; \
    for (sort keys %help) { \
    print "${WHITE}$$_:${RESET}\n"; \
    for (@{$$help{$$_}}) { \
    $$sep = " " x (42 - length $$_->[0]); \
    print "  ${YELLOW}$$_->[0]${RESET}$$sep${GREEN}$$_->[1]${RESET}\n"; \
    }; \
    print "\n"; }

# ------ #
# GLOBAL #
# ------ #
.PHONY: help
help: ##@Global Show this help.
	@perl -e '$(HELP_FUN)' $(MAKEFILE_LIST)

.PHONY: initialize
initialize: pull install_vendors reset_db ##@Global Git pull, install vendors, reset db
	@echo "$(_PREFIX)$(OK_COLOR)API ready to use$(NO_COLOR)."

.PHONY: start
start: ##@Global Launch API server
	@echo "$(_PREFIX)$(WARN_COLOR)Launch API server$(NO_COLOR)"
	symfony server:start

.PHONY: pull
pull: ##@Global Pull latest version from github
	@echo "$(_PREFIX)$(WARN_COLOR)Pull latest version from Github$(NO_COLOR)"
	git pull
	@echo "$(_PREFIX)$(OK_COLOR)Latest API version retrieved$(NO_COLOR)"

.PHONY: install_vendors
install_vendors: ##@Global Execute composer install
	@echo "$(_PREFIX)$(WARN_COLOR)Installing vendors$(NO_COLOR)"
	composer install --no-progress
	@echo "[$(OK_COLOR)Vendor installed$(NO_COLOR)]"

.PHONY: clean_cache
clean_cache: ##@Global Clean API cache
	@echo "$(_PREFIX)$(WARN_COLOR)Clearing API container cache...$(NO_COLOR)"
	bin/console c:c
	@echo "[$(OK_COLOR)API cache clear$(NO_COLOR)]"

.PHONY: test_behat
test_behat: ##@Global Execute API behat tests
	$(WAIT_FOR_CONTAINER) $(API_CONTAINER)
	bin/behat -vvv

# -- #
# DB #
# -- #
.PHONY: create_db
create_db: ##@Database Create database if not exists
	@echo "$(_PREFIX)$(WARN_COLOR)Creating database$(NO_COLOR)"
	bin/console doctrine:database:create --if-not-exists
	@echo "[$(OK_COLOR)Database created$(NO_COLOR)]"

.PHONY: drop_db
drop_db: ##@Database Drop database if exists
	@echo "$(_PREFIX)$(WARN_COLOR)Drop database$(NO_COLOR)"
	bin/console doctrine:database:drop --if-exists --force
	@echo "[$(OK_COLOR)Database deleted$(NO_COLOR)]"

.PHONY: migrate_db
migrate_db: ##@Database Run database migrations
	@echo "$(_PREFIX)$(WARN_COLOR)Migrating doctrine schema...$(NO_COLOR)"
	bin/console doctrine:migration:migrate -n -q
	@echo "[$(OK_COLOR)Schema migrated$(NO_COLOR)]"

.PHONY: update_schema
update_schema: ##@Database Update doctrine schema
	@echo "$(_PREFIX)$(WARN_COLOR)update doctrine schema...$(NO_COLOR)"
	bin/console doctrine:schema:update -n -q -f
	@echo "[$(OK_COLOR)done$(NO_COLOR)]"

.PHONY: gen_fixtures_db
gen_fixtures_db: ##@Database Load fixtures
	@echo "$(_PREFIX)$(WARN_COLOR)Loading fixtures$(NO_COLOR)"
	bin/console doctrine:fixtures:load --no-interaction --verbose
	@echo "[$(OK_COLOR)Fixtures loaded$(NO_COLOR)]"

.PHONY: reset_db
reset_db: drop_db create_db migrate_db gen_fixtures_db ##@Database drops, creates, migrates, generates fixtures
