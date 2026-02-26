import fs from "fs";
import path from "path";
import { fileURLToPath } from "url";
import { glob } from "glob";
import sharp from "sharp";
import { themeName } from "./theme.config.js";

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const SRC_IMG = path.join(__dirname, "src", "images");
const DEST_IMG = path.join(__dirname, "..", themeName, "assets", "images");

function hasSourceForWebp(webpRel, srcDir) {
  const base = webpRel.replace(/\.webp$/i, "");
  for (const ext of [".jpg", ".jpeg", ".png", ".gif"]) {
    if (fs.existsSync(path.join(srcDir, base + ext))) return true;
  }
  return false;
}

function removeEmptyDirs(dir, root) {
  if (!fs.existsSync(dir)) return;
  const entries = fs.readdirSync(dir, { withFileTypes: true });
  for (const e of entries) {
    if (e.isDirectory()) removeEmptyDirs(path.join(dir, e.name), root);
  }
  if (dir !== root && fs.readdirSync(dir).length === 0) {
    fs.rmdirSync(dir);
  }
}

async function buildImages() {
  if (!fs.existsSync(SRC_IMG)) {
    return;
  }

  const files = await glob("**/*.{jpg,jpeg,png,gif}", {
    cwd: SRC_IMG,
    absolute: true,
  });

  const destWebps = fs.existsSync(DEST_IMG)
    ? await glob("**/*.webp", { cwd: DEST_IMG, absolute: true })
    : [];
  for (const webpPath of destWebps) {
    const rel = path.relative(DEST_IMG, webpPath);
    if (!hasSourceForWebp(rel, SRC_IMG)) {
      fs.unlinkSync(webpPath);
    }
  }
  if (fs.existsSync(DEST_IMG)) {
    removeEmptyDirs(DEST_IMG, DEST_IMG);
  }

  for (const file of files) {
    const relPath = path.relative(SRC_IMG, file);
    const ext = path.extname(relPath);
    const webpRel = relPath.slice(0, -ext.length) + ".webp";
    const webpPath = path.join(DEST_IMG, webpRel);
    fs.mkdirSync(path.dirname(webpPath), { recursive: true });
    try {
      await sharp(file).webp({ quality: 80 }).toFile(webpPath);
    } catch (e) {}
  }

  // SVG などそのままコピー（_vite/src/images → theme/assets/images、ディレクトリ構造を維持）
  const copyExts = [".svg"];
  for (const ext of copyExts) {
    const copyFiles = await glob(`**/*${ext}`, { cwd: SRC_IMG, absolute: true });
    for (const file of copyFiles) {
      const relPath = path.relative(SRC_IMG, file);
      const destPath = path.join(DEST_IMG, relPath);
      fs.mkdirSync(path.dirname(destPath), { recursive: true });
      fs.copyFileSync(file, destPath);
    }
  }
}

buildImages().catch((err) => {
  console.error(err);
  process.exit(1);
});
