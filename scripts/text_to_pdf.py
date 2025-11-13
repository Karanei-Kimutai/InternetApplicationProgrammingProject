#!/usr/bin/env python3
import subprocess
import sys
from pathlib import Path

def simplify(line: str) -> str:
    stripped = line.lstrip('#').lstrip()
    return stripped if stripped else ''

def escape_ps(text: str) -> str:
    return text.replace('\\', r'\\').replace('(', r'\(').replace(')', r'\)')


def text_to_postscript(text: str, title: str) -> str:
    lines = text.splitlines()
    ps_lines = ["%!PS-Adobe-3.0", f"%%Title: {title}", "/Courier findfont 11 scalefont setfont"]
    x_margin = 54
    y = 780
    line_height = 14
    ps_lines.append(f"{x_margin} {y} moveto")

    def new_page(current_y: int) -> int:
        ps_lines.append("showpage")
        new_y = 780
        ps_lines.append(f"{x_margin} {new_y} moveto")
        return new_y

    for raw in lines:
        line = simplify(raw)
        if not line:
            y -= line_height
            if y <= 72:
                y = new_page(y)
            ps_lines.append(f"{x_margin} {y} moveto")
            continue
        escaped = escape_ps(line)
        ps_lines.append(f"({escaped}) show")
        y -= line_height
        if y <= 72:
            y = new_page(y)
            ps_lines.append(f"{x_margin} {y} moveto")
    ps_lines.append("showpage")
    return "\n".join(ps_lines)


def convert(input_path: Path, output_path: Path) -> None:
    text = input_path.read_text(encoding='utf-8')
    ps_content = text_to_postscript(text, output_path.stem)
    tmp_ps = output_path.with_suffix('.ps')
    tmp_ps.write_text(ps_content, encoding='utf-8')
    try:
        subprocess.run([
            'gs', '-dBATCH', '-dNOPAUSE', '-sDEVICE=pdfwrite',
            f'-sOutputFile={output_path}', str(tmp_ps)
        ], check=True, stdout=subprocess.DEVNULL, stderr=subprocess.DEVNULL)
    finally:
        tmp_ps.unlink(missing_ok=True)


def main():
    if len(sys.argv) != 3:
        print("Usage: text_to_pdf.py <input> <output>")
        sys.exit(1)
    convert(Path(sys.argv[1]), Path(sys.argv[2]))

if __name__ == '__main__':
    main()
