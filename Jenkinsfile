pipeline {
    agent any

    environment {
        REPO_URL = 'https://git@github.com:ideastarboy/php-crud-app.git'
        NEXUS_REPO = 'dev-team-30'
        ARTIFACT_NAME = 'myapp.zip'
        NEXUS_URL = 
        ARTIFACT_URL = "${NEXUS_URL}/repository/${NEXUS_REPO}/${ARTIFACT_NAME}"
        SLACK_WEBHOOK_URL = 
    }

    stages {
        stage('Install PHP') {
            steps {
                sh 'ansible-playbook  -i /etc/ansible/hosts /etc/ansible/php.yml'
            }
        }

        stage('Install MySQL') {
            steps {
                sh 'ansible-playbook  -i /etc/ansible/hosts /etc/ansible/mysql.yml'
            }
        }

        stage('Install Java') {
            steps {
                sh 'ansible-playbook  -i /etc/ansible/hosts /etc/ansible/java.yml'
            }
        }

        stage('Install Apache') {
            steps {
                sh 'ansible-playbook  -i /etc/ansible/hosts /etc/ansible/playbook_apache.yml'
            }
        }

        stage('Clone Repository') {
            steps {
                git branch: 'main', url: 'https://github.com/ideastarboy/php-crud-app.git'
            }
        }

        stage('Build PHP') {
            steps {
                sh 'php -l index.php' // Syntax check
                sh 'composer install --no-dev --optimize-autoloader' // Install dependencies
                sh 'zip -r myapp.zip .' // Create a build artifact
            }
        }

        stage('Upload to Nexus') {
            steps {
                withCredentials([usernamePassword(credentialsId: 'nexus-jenks', passwordVariable: 'NEXUS_PASS', usernameVariable: 'NEXUS_USER')]) {
                    sh '''
                        curl -v -X PUT --user $NEXUS_USER:$NEXUS_PASS \
                        --upload-file myapp.zip \
                        ${ARTIFACT_URL}
                    '''
                }
            }
        }

        stage('Deploy to Staging') {
            agent any
            steps {
                sh '''
                    ansible-playbook  -i /etc/ansible/hosts /etc/ansible/deploy_staging.yml \
                    --extra-vars "artifact_url=${NEXUS_URL}myapp.zip"
                '''
            }
        }

        stage('Slack Approval for Production') {
            steps {
                script {
                    def slackMessage = """{
                        \"text\": \"Staging deployment complete. Approve to deploy to production?\",\n                        \"channel\": \"#deployments\",
                        \"username\": \"JenkinsBot\",
                        \"icon_emoji\": \":rocket:\"
                    }"""
                    httpRequest(
                        httpMode: 'POST',
                        url: SLACK_WEBHOOK_URL,
                        contentType: 'APPLICATION_JSON',
                        requestBody: slackMessage
                    )

                    input message: 'Promote to production?', ok: 'Deploy'
                }
            }
        }

        stage('Deploy to Production') {
            agent any
            steps {
                sh '''
                    ansible-playbook  -i /etc/ansible/hosts /etc/ansible/deploy_prod.yml \
                    --extra-vars "artifact_url=${NEXUS_URL}myapp.zip"
                '''
            }
        }
    }

    post {
        success {
            script {
                def slackMessage = """{
                    \"text\": \"Production deployment successful!\",\n                    \"channel\": \"#deployments\",
                    \"username\": \"JenkinsBot\",
                    \"icon_emoji\": \":tada:\"
                }"""
                httpRequest(
                    httpMode: 'POST',
                    url: SLACK_WEBHOOK_URL,
                    contentType: 'APPLICATION_JSON',
                    requestBody: slackMessage
                )
            }
        }

        failure {
            script {
                def slackMessage = """{
                    \"text\": \"Production deployment failed.\",\n                    \"channel\": \"#deployments\",
                    \"username\": \"JenkinsBot\",
                    \"icon_emoji\": \":warning:\"
                }"""
                httpRequest(
                    httpMode: 'POST',
                    url: SLACK_WEBHOOK_URL,
                    contentType: 'APPLICATION_JSON',
                    requestBody: slackMessage
                )
            }
        }
    }
}
