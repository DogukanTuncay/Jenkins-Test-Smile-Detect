pipeline {
    agent any
 environment {
        APP_PORT = "8081"
        VITE_PORT = "5173"
        DB_PORT = "3306"
        DB_DATABASE = "test-app"
        DB_USERNAME = "root"
        DB_PASSWORD = "root"
        WWWGROUP = "1000"
        WWWUSER = "1000"
        SAIL_XDEBUG_MODE = "off"
        SAIL_XDEBUG_CONFIG = "client_host=host.docker.internal"
        PWD = "${WORKSPACE}" // Jenkins'in o anki çalışma alanını dinamik olarak alır
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
                }
            }
        }

        stage('Build Docker Image') {
            steps {
                // Mevcut dizini logla
                sh 'echo "Current Directory: $(pwd)"'

                // Tüm dosyaları ve dizinleri listele
                sh 'echo "Listing all files and directories:"'
                sh 'ls -la'
                sh 'composer install'
                // Docker imajını oluştur
                sh 'docker-compose build --no-cache --build-arg USER_ID=$(id -u) --build-arg GROUP_ID=$(id -g)'
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
