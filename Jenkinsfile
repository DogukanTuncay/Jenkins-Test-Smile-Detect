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

        // Bağımlılıkları yükle
        stage('Install Dependencies') {
            steps {
                // PHP Composer bağımlılıklarını yükle
                sh 'composer install'

                // .env dosyasını oluştur ve uygulama anahtarını oluştur
                sh 'cp .env.example .env'
                sh 'php artisan key:generate'
            }
        }

        // Testleri çalıştır
        stage('Run Tests') {
            steps {
                // PHPUnit testlerini çalıştır
                sh 'php artisan test'
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
            // Test sonuçları veya hata raporları için herhangi bir ekleme yapılabilir
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
