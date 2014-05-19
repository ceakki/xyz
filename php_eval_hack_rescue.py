import os
import re
import sys



try:
    any
except NameError:
    def any(s):
        for v in s:
            if v:
                return True
        return False



def is_php(source_path):
    return source_path.lower().endswith(".php")



def do_action(source_path, pattern, string_after, action):
    source = open(source_path, 'r')

    # if the pattern if not in the file stop here
    if not any(re.search(pattern, line) for line in source):
        return

    # if pattern is in the file, perform cleanup
    else:
        log = open(os.path.dirname(os.path.abspath(__file__)) + "/" + action + ".log", "a")
        log.write(source_path + "\n")
        log.close()

        if action == "replace":

            out_source_path = source_path + ".tmp"
            target = open(out_source_path, "w")
            source.seek(0, 0)
            for line in source:
                if re.search(pattern, line):
                    line = re.sub(pattern, string_after, line)
                target.write(line)
            target.close()
            source.close()

            os.rename(out_source_path, source_path)
            print "cleaned: " + source_path

        else:
            print "found: " + source_path



def dig_in(dir_name, string_before, string_after, action):
    pattern = re.compile(string_before)
    for dir_path, dir_names, file_names in os.walk(dir_name):
        for source_file in file_names:
            if is_php(source_file):
                source_path = os.path.join(dir_path, source_file)
                do_action(source_path, pattern, string_after, action)



if len(sys.argv) != 2:
    u = "Usage: php_eval_hack_rescue.py <path> <find/replace>\nSecond arg is optional. Defaults to find.\n"
    sys.stderr.write(u)
    sys.exit(1)



action = "find"
if len(sys.argv) > 2:
    if sys.argv[2] in ["find", "replace"]:
        action = sys.argv[2]



if os.path.exists(sys.argv[1]):
    print action[0].upper() + action[1:] + "ing... please wait."
    dig_in(sys.argv[1], "eval\(base64_decode\([^\);]*\)\);", "", action)
    print "\nThat's all folks."

else:
    u = "Invalid path provided\n"
    sys.stderr.write(u)
    sys.exit(1)
