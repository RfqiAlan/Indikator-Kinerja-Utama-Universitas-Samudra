import re

with open('pdf_content.txt', 'r') as f:
    text = f.read()

# We try to extract "Formula" sections for each IKU.
# We will split by "NO. IKU DEFINISI, KRITERIA, KETENTUAN, DAN FORMULA" or just look for "Formula" following a number.
sections = re.finditer(r'([0-9]+\.\s+.*?)(?=[0-9]+\.\s+[A-Za-z]|\Z)', text, re.DOTALL)
for s in sections:
    snippet = s.group(1)
    if 'Formula' in snippet:
        # get the first few lines and the Formula part
        lines = snippet.split('\n')
        name = lines[0].strip()
        print(f"--- {name} ---")
        formula_block = False
        for line in lines:
            if line.startswith('Formula'):
                formula_block = True
            elif formula_block and (line.startswith('Satuan') or line.startswith('NO.') or line.startswith('SASARAN')):
                formula_block = False
            
            if formula_block:
                print(line.strip())
        print()
