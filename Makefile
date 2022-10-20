build: ##@Intsall Dependencies
	composer install
up: ##@Run locally
	docker-compose up -d --build
down: ##@Stop containers
	docker-compose down
clean: ##@Docker clear all images
	docker rmi -f $$(docker images -q)
deploy: ##@Build and deploy to Cloud Run
	gcloud builds submit --tag gcr.io/kibarodev-75382/meal-wallet-authentication-svc
	gcloud beta run deploy --image gcr.io/kibarodev-75382/meal-wallet-authentication-svc --platform managed --allow-unauthenticated

