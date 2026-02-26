## ファイルの特徴
- WordPress テーマ用のコーディング環境（Vite）
- `_vite/src` 内の SCSS / JS / 画像はビルドで `wp-theme/assets/` に反映される

## このコーディングファイルの使い方
以下を必ずお読みください。

- 使用環境
- 使い方および操作方法
- 注意点

## 使用環境
- Node.js バージョン 14 系以上
- npm バージョン 8 以上
- バージョン確認（ターミナルで実行）：
  - `node -v`
  - `npm -v`
- 数字が表示されれば問題ありません

## 使い方および操作方法
1. ターミナルを開く
2. `cd _vite` でビルド用フォルダへ移動する
3. `npm install` を実行
4. ダウンロードが完了したら、次のコマンドでビルド・開発ができます（いずれも `_vite` フォルダ内で実行）

```bash
cd _vite
npm install   # 初回のみ
npm run serve # 開発はこれだけでOK。http://localhost:5173 で表示し、SCSS/JS/画像の変更で自動ビルド・リロード（画像は WebP 変換あり）
npm run build # 納品・提出前の本番ビルド（CSS/JS + 画像の圧縮・WebP 変換）
```

### コマンド一覧
| コマンド | 説明 |
|----------|------|
| `npm run serve` | **開発時はこれを使う。** `http://localhost:5173` で表示し、PHP・SCSS・JS・画像の変更で自動リロード。画像は `_vite/src/images/` に置くと自動で WebP 変換されます |
| `npm run build` | 本番用ビルド（CSS・JS をビルドし、画像を圧縮・WebP 変換して `wp-theme/assets/` に出力） |
| `npm run build:images` | 画像の WebP 変換のみ実行（画像だけ追加したときに手動で回す用） |

### 開発サーバー（npm run serve）の動き
- **localhost で見る**: ブラウザで `http://localhost:5173` を開くと `http://test.localtest/` の内容がプロキシ表示されます。
- **自動リロード**（http://localhost:5173/ のブラウザが自動でリロードされます）:
  - **PHP**: `wp-theme/**/*.php` を監視
  - **SCSS/JS**: 変更を検知して `wp-theme/assets/` にビルドし、ビルド結果の変更を検知してリロード
  - **画像**: `_vite/src/images/` に画像やフォルダを追加すると自動で WebP 変換し `wp-theme/assets/images/` に出力
  - **JS**: `_vite/src/js/` 内のすべての `.js` が個別にビルドされ `wp-theme/assets/js/` に出力。新規 JS 追加時もビルドが自動で再起動しすぐ反映されます。

### 仕組み
- `_vite/package.json` を参照して必要なパッケージをインストールします。
- ビルド結果は **WordPress テーマ（wp-theme）内** にのみ出力されます（dist フォルダは使いません）。

## コーディング時の操作方法
- **編集するのは `_vite/src` フォルダ内のみ**
- `_vite/src` 内の変更はビルドで `wp-theme/assets/`（CSS・JS・画像）に反映されます
- `wp-theme` 内の PHP やビルド済みファイルは、必要に応じてのみ編集してください

## ファイルの特徴
- スマホファースト / パソコンファーストの切り替えが可能（変数で管理）
  - `_vite/src/sass/global/_breakpoints.scss` の変数を `pc` または `sp` に設定（初期値：`sp`）
  - 資料動画を参照してください

## 注意点
- `_vite/src/sass/base/` フォルダ内は変更を加えないこと
- 納品時（提出時）は `_vite` 内の `node_modules` を削除すること
- 提出時は `npm run build` を実行し、フォルダ内を整理した状態で提出すること

## サイトごとの設定
別のサイトでこの環境を使うときは、**`_vite/theme.config.js` の 1 か所だけ**を変更する。
- **themeName** … テーマフォルダ名（`_vite` のひとつ上のフォルダ名と一致させる）
- **PROXY_TARGET** … 開発サーバー（`npm run serve`）でプロキシする WordPress の URL（例: `http://xxx.localtest`）