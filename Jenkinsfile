pipeline {
    agent any

        environment {
        DB_DATABASE = credentials('db-database-credential-id')
        DB_CREDENTIALS = credentials('db-credential-id')
    }


    stages {
        // Projeyi GitHub'dan çek
        stage('Checkout') {
            steps {
                // GitHub deposundan kodu çekiyoruz
                git branch: 'main', url: 'https://github.com/DogukanTuncay/Jenkins-Test-Smile-Detect'
            }
        }
         stage('Create .env File') {
            steps {
                script {
                    // .env dosyasını .env.example'dan oluşturma
                    sh 'cp .env.example .env'
                    sh "echo 'DB_DATABASE=${DB_DATABASE}' >> .env"
                    sh "echo 'DB_USERNAME=${ DB_CREDENTIALS.username}' >> .env"
                    sh "echo 'DB_PASSWORD=${ DB_CREDENTIALS.password}' >> .env"
                    sh 'php artisan key:generate'
                }
            }
        }

        stage('Build Docker Image') {
            steps {
                // Docker imajını oluştur
                sh 'docker build -t laravel-app .'
            }
        }

        stage('Run Docker Container') {
            steps {
                // Docker konteynerini çalıştır
                sh 'docker run -d -p 8081:80 laravel-app'
            }
        }
        stage('Run Migrations') {
            steps {
                script {
                    sh 'docker run --rm laravel-app php artisan migrate'
                }
            }
        }

        stage('Run Tests') {
            steps {
                sh 'docker run --rm laravel-app php artisan test'
            }
        }

        // Build işlemi (opsiyonel)
        stage('Build') {
            steps {
                // Eğer bir build işleminiz varsa burada tanımlayın, şu an sadece örnek echo kullanılıyor
                echo 'Build process here...'
            }
        }
    }

    // Hata durumunda bildirimi sağlayacak post aşaması
    post {
        always {

            echo 'Pipeline tamamlandı'

        }
        success {

            echo 'Pipeline başarıyla tamamlandı'

        }
        failure {

            echo 'Pipeline başarısız oldu'

        }
    }
}
