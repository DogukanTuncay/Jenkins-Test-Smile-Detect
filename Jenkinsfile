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

        stage('Build Docker Image') {
            steps {
                // Docker imajını oluştur
                sh 'docker build -t laravel-app .'
            }
        }

        stage('Run Docker Container') {
            steps {
                // Docker konteynerini çalıştır
                sh 'docker run -d -p 8000:80 laravel-app'
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
