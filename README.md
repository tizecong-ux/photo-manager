# 写真管理システム

## 概要
・PHP(Laravel) + MySQL + Nginxを Docker で構築しています。

・composerのインストールが必要となっております。お手数をおかけしますが、事前にインストールをお願いいたします。
Composer公式ドキュメント : https://getcomposer.org/download/

### セットアップ手順

1. 環境変数ファイルを作成します。

```bash
cp .env.example .env
```

2. `.env` ファイルを開いて、最終行にお渡しした接続情報を追記してください。

3. Composer 依存関係をインストールします。

```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs
```

4. Sail を起動します。

```bash
./vendor/bin/sail up -d
```

5. アプリケーションキーを生成します。

```bash
./vendor/bin/sail artisan key:generate
```

6. データベースマイグレーション及び、テストデータの投入を行います。

```bash
./vendor/bin/sail artisan migrate:refresh --seed
```

7. npm パッケージをインストールしてビルドします。

```bash
./vendor/bin/sail npm install
./vendor/bin/sail npm run build
```

8. storage を公開用にリンクします。

```bash
./vendor/bin/sail artisan storage:link
```

9. [http://localhost:3000](http://localhost:3000) にアクセスするとシステムが表示されます。

### テストアカウント
3件のテストアカウントを用意しております。以下の情報でログインできます。

アカウント1
ID : test1@example.com
Pass : password1

アカウント2
ID : test2@example.com
Pass : password2

アカウント3
ID : test3@example.com
Pass : password3

### テストコード
以下のコマンドで作成したテストコードを全件実行できます。

```bash
./vendor/bin/sail artisan test --testsuite=Feature
```