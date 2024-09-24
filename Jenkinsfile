pipeline {
    agent any

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
                }
            }
        }

        stage('Build Docker Image') {
            steps {
                // Docker imajını oluştur
                sh 'docker-compose build'
            }
        }

        stage('Run Docker Compose Up') {
            steps {
                // Docker Compose ile konteynerleri çalıştır
                sh 'docker-compose up -d'
            }
        }

        stage('Run Migrations') {
            steps {
                script {
                    // Migrate işlemini çalıştır
                    sh 'docker-compose exec app php artisan migrate'
                }
            }
        }

        stage('Run Tests') {
            steps {
                // Testleri çalıştır
                sh 'docker-compose exec app php artisan test'
            }
        }

        stage('Build Key') {
            steps {
                // Anahtar oluşturma işlemi
                sh 'docker-compose exec app php artisan key:generate'
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
