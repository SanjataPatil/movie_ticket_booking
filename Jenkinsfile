pipeline {
    agent any

    environment {
        DOCKER_HOST_IP = "13.232.154.67"
        DOCKER_USER = "ubuntu"
        DOCKER_APP_DIR = "movie-ticket-booking-app"
    }

    stages {
        stage('Clone Repository') {
            steps {
                git branch: 'main', url: 'https://github.com/SanjataPatil/movie_ticket_booking.git'
            }
        }

        stage('Build Docker Image') {
            steps {
                withCredentials([sshUserPrivateKey(credentialsId: 'ec2-ssh-key', keyFileVariable: 'KEY')]) {
                    sh """
                        ssh -i \$KEY -o StrictHostKeyChecking=no ${DOCKER_USER}@${DOCKER_HOST_IP} \\
                            "rm -rf ${DOCKER_APP_DIR} && mkdir -p ${DOCKER_APP_DIR}"

                        scp -i \$KEY -o StrictHostKeyChecking=no -r src public  Dockerfile package.json package-lock.json index.html \\
                            bun.lockb components.json eslint.config.js postcss.config.js tailwind.config.ts tsconfig.app.json tsconfig.json tsconfig.node.json vite.config.ts \\
                            ${DOCKER_USER}@${DOCKER_HOST_IP}:${DOCKER_APP_DIR}/
                    """
                }
            }
        }

        stage('Run Container') {
            steps {
                withCredentials([sshUserPrivateKey(credentialsId: 'ec2-ssh-key', keyFileVariable: 'KEY')]) {
                    sh """
                        ssh -i \$KEY -o StrictHostKeyChecking=no ${DOCKER_USER}@${DOCKER_HOST_IP} \\
                            "cd ${DOCKER_APP_DIR} && \\
                             docker build -t vite-story-app . && \\
                             docker rm -f vite-story-container || true && \\
                             docker run -d -p 80:80 --name vite-story-container vite-story-app"
                    """
                }
            }
        }

      stage('Selenium Tests') {
            steps {
                sh """
                    echo "Running Selenium tests..."
                    # TODO: Add your Selenium test command here
                """
            }
        }
    }
}
